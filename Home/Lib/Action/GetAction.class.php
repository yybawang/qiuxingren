<?php
class GetAction extends HomeAction{
	
	private $dA = '';		//D方法实例化 article 表
	private $dI = '';		//D方法实例化 image 表
	private $dC = '';		//D方法实例化 comment 表
	private $dU = '';		//D方法实例化 user 表
	
	private $last = '';
	private $zol_page = '';
	private $table_a = '';
	private $table_i = '';
	
	
	private $get_site = 'http://www.qiushibaike.com/';
	
	private $jyq_site = 'http://www.juyouqu.com/';
	private $zol_site = 'http://xiaohua.zol.com.cn/';
	
	public function _initialize(){
		parent::_initialize();
		import('@.Widget.phpQueryOne');
		$this->dA = D('Article');
		$this->dI = D('Image');
		$this->dC = D('Comment');
		$this->dU = D('User');
		
		$this->table_a = C('DB_PREFIX').'article';
		$this->table_i = C('DB_PREFIX').'image';
		
		if(isset($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}else{
			$page = 1;
		}
		$this->zol_page = $page.'.html';
		$this->last = 'page/'.$page;
	}
	
	public function index(){
		$this->get_qiubai_article();
	}
	public function late(){
		$this->get_qiubai_article();
	}
/****************************************************
*
*	抓取 www.qiushibaike.com 的文章
*
****************************************************/	
//抓取最新
public function get_qiubai_article($cate = 'late',$return = 0){
	$data = $this->get_article($this->get_site.$cate.'/'.$this->last);
	foreach($data as $key => $val){
		$data_article = $val;
		unset($data_article['image']);		//插入文章不带图片
		$article_id = $this->dA->add($data_article);
		if(!empty($val['image']) && !empty($article_id)){
			foreach($val['image'] as $img_k => $img_v){
				$data_image['article_id'] = $article_id;
				$data_image['image_link'] = $img_v['image_link'];
				$this->dI->add($data_image);
			}
		}
		
		if($val['user_id'] > 0){
			$user_info = $this->dU->getUserInfoById($val['user_id']);
			$val['former_user_id'] = $user_info['user_id'];
			$val['former_user_name'] = $user_info['user_name'];
			$val['former_user_email'] = $user_info['email'];
			$val['pic'] = $user_info['pic'];
		}else{
			//否则是抓取的文章，抓取也有空头像
			if(empty($val['pic'])){
				$val['pic'] = __PUBLIC__.'/public/images/default_pic.jpg';
			}
		}
		//评论数量
		$val['comment_count'] = $this->dC->getCommentCount($val['former_id']);
		$data[$key] = $val;
	}
	if($return){
		return $data;
	}else{
		print_r($data);
	}
}
	
	
	
	
	

/****************************************************
*
*	抓取 www.juyouqu.com 的文章
*
****************************************************/
//抓取 热门 栏目
public function juyouqu_hot_article(){
	$aReturn = $this->get_juyouqu($this->jyq_site.$this->last);
	foreach($aReturn as $key => $val){
		//评论数量
		$val['comment_count'] = $this->dC->getCommentCount($val['former_id']);
		$aReturn[$key] = $val;
	}
	return $aReturn;
}

/*****************************************************
*
*	抓取中关村笑话		// 翻页链接加 2.html
*	http://xiaohua.zol.com.cn/new/
*	http://xiaohua.zol.com.cn/qutu/
*
*****************************************************/
public function get_zol_article($nav='new'){
	$aReturn = $this->get_zol($this->zol_site.$nav.'/'.$this->zol_page);
	foreach($aReturn as $key => $val){
		//评论数量
		// $val['comment_count'] = $this->dC->getCommentCount($val['former_id']);
		$val['comment_count'] = 0;
		$aReturn[$key] = $val;
	}
	return $aReturn;
}
	
	
	
	
	
	
	/**
	*	糗百返回抓取信息
	**/
	private function get_article($site){
		phpQuery::$debug = false;
		/** 抓取出错，定向成了 m.qiushibaike.com **/
		$html = curl($site);
		$get_file_path = __UPLOAD__.'/get.html';
		unlink($get_file_path);		//存在即删除
		$tp = @fopen($get_file_path, 'a');
		fwrite($tp, $html);
		fclose($tp);
		
		$pq = phpQuery::newDocumentFile($get_file_path);
		$qiu_article = $pq->find('#content-left .article');
		
		foreach($qiu_article as $key => $val){
			//--------------	抓取格式开始
			$get_data['user_id'] 		= 0;															//用户ID
			$get_data['title'] 			= '';
			$get_data['content']		= trim(pq($val)->find('.content')->text());						//主内容
			$get_data['up'] 			= pq($val)->find('.up .number')->text();						//顶
			$get_data['down'] 			= pq($val)->find('.down .number')->text();						//拍
			$get_data['add_time'] 		= time();														//添加时间
			$get_data['former_id'] 	= $get_data['id']	= pq($val)->find('.up .voting')->attr('data-article');			//糗百原ID
			$former_user_href 			= pq($val)->find('.author a:eq(1)')->attr('href');		
			preg_match('/\d{1,15}/',$former_user_href,$match);
			$get_data['former_user_id'] = $match[0];													//糗百原用户ID
			$get_data['former_user_name']= trim(pq($val)->find('.author a:eq(1)')->text());				//糗百原用户名
			$get_data['pic'] 			= pq($val)->find('.author img')->attr('src');					//糗百原用户头像
			//--------------	抓取格式结束
			
			//五分之一的概率把文章放入审核下
			$rand = rand(1,10);
			if($rand <=2){
				$get_data['is_show'] = 0;
			}else{
				$get_data['is_show'] = 1;
			}
			
			//查找到对应的zone区
			$get_data['zone'] = 0;
			foreach(C('ZONE') as $zk => $zv){
				foreach($zv as $keyword){
					if(stripos($get_data['content'],$keyword)){
						$get_data['zone'] = $zk+1;
						break;
					}
				}
				if(!empty($get_data['zone'])){
					break;
				}
			}
			
			//替换关键字--比如把 糗百 替换成 糗星人
			foreach(C('REPLACE_KEYWORDS') as $keyword){
				$get_data['content'] = str_replace($keyword[0],$keyword[1],$get_data['content']);
			}
			
			//$article_id = $this->dA->data($data)->add();	//插入文章表得到文章ID
			$return[$key] =  $get_data;
			
			
			// $if_image = pq($val)->find('.thumb img')->attr('src');		//不能直接img，出错空白
			$if_image = pq($val)->find('.thumb > a')->html();
			preg_match('/\"http.*?\"/is',$if_image,$match);
			$match[0] = str_replace('"','',$match[0]);
			$if_image = $match[0];
			//如果有图片继续插入图片
			if(!empty($if_image)){
				//$image_data['article_id'] = $article_id;
				$image_data = $if_image;
				//$this->dI->data($image_data)->add();
				$return[$key]['image'] = array(array('image_link'=>$image_data));
			}
		}
		return $return;
	}

		
	/**
	*	具有趣网的抓取
	**/
	private function get_juyouqu($site){
		phpQuery::$debug = false;
		$html = curl($site);
		$get_file_path = __UPLOAD__.'/get.html';
		unlink($get_file_path);		//存在即删除
		$tp = @fopen($get_file_path, 'a');
		fwrite($tp, $html);
		fclose($tp);
		
		$pq = phpQuery::newDocumentFile($get_file_path);
		$qiu_article = $pq->find('.entryCollection .article');
		foreach($qiu_article as $key => $val){
			$get_data['user_id'] = 0;
			$get_data['title'] = '';
			$get_data['content'] = trim(pq($val)->find('.itemTitle .evt')->text());
			$get_data['up'] = pq($val)->find('.itemLoveCount')->text();
			$get_data['down'] = 0;
			$get_data['add_time'] = time();
			$former_id = pq($val)->find('.itemTitle .evt')->attr('href');
			preg_match('/\d{1,15}/',$former_id,$match);
			$get_data['former_id'] = $get_data['id'] = $match[0];
			$get_data['former_user_id'] = 0;													//糗百原用户ID
			$get_data['former_user_name']= '';
			$get_data['pic'] 			= __PUBLIC__.'/public/images/default_pic.jpg';
			
			$if_image = pq($val)->find('.animatedContainerStatic a.track img')->attr('data-src');
			if(empty($if_image)){
				$if_image = pq($val)->find('.animatedContainerStatic a.track img')->attr('src');
			}
			if(!empty($if_image)){
				$image_data = $if_image;
				$get_data['image'] = array(0 => array('image_link'=>$image_data));
			}else{
				unset($get_data['image']);
			}
			
			//查找到对应的zone区
			$get_data['zone'] = 0;
			foreach(C('ZONE') as $zk => $zv){
				foreach($zv as $keyword){
					if(stripos($get_data['content'],$keyword)){
						$get_data['zone'] = $zk+1;
						break;
					}
				}
				if(!empty($get_data['zone'])){
					break;
				}
			}
			
			//替换关键字--比如把 糗百 替换成 糗星人
			foreach(C('REPLACE_KEYWORDS') as $keyword){
				$get_data['content'] = str_replace($keyword[0],$keyword[1],$get_data['content']);
			}
			
			$aReturn[$key] = $get_data;
		}
		return $aReturn;
	}
	
	
	
	
	/**
	*	中关村网的抓取
	**/
	private function get_zol($site){
		phpQuery::$debug = false;
		$html = curl($site);
		$html = iconv('gbk','utf-8',$html);
		$get_file_path = __UPLOAD__.'/get.html';
		unlink($get_file_path);		//存在即删除
		$tp = @fopen($get_file_path, 'a');
		fwrite($tp, $html);
		fclose($tp);
		
		$pq = phpQuery::newDocumentFile($get_file_path);
		$qiu_article = $pq->find('.article-list .article-summary');
		foreach($qiu_article as $key => $val){
			$get_data['user_id'] = 0;
			$get_data['title'] = trim(pq($val)->find('.article-title a')->text());
			$get_data['content'] = trim(pq($val)->find('.summary-text')->text());
			$get_data['up'] = rand(70,300);
			$get_data['down'] = rand(0,30);
			$get_data['add_time'] = time();
			$former_id = pq($val)->find('.articleCommentbar')->attr('data-id');
			$get_data['former_id'] = $former_id;
			$get_data['id'] = $former_id;
			$get_data['former_user_id'] = 0;
			$get_data['former_user_name']= pq($val)->find('.nike-name')->text();
			$get_data['pic'] = __PUBLIC__.'/public/images/default_pic_zol.jpg';
			
			
			if(empty($get_data['content'])){
				$image_data = trim(pq($val)->find('.summary-text img')->attr('loadsrc'));
				if(empty($image_data)){
					$image_data = trim(pq($val)->find('.summary-text img')->attr('src'));
				}
				$get_data['image'] = array(0 => array('image_link'=>$image_data));
			}else{
				unset($get_data['image']);
			}
			
			//查找到对应的zone区
			$get_data['zone'] = 0;
			foreach(C('ZONE') as $zk => $zv){
				foreach($zv as $keyword){
					if(stripos($get_data['content'],$keyword)){
						$get_data['zone'] = $zk+1;
						break;
					}
				}
				if(!empty($get_data['zone'])){
					break;
				}
			}
			
			//替换关键字--比如把 糗百 替换成 糗星人
			foreach(C('REPLACE_KEYWORDS') as $keyword){
				$get_data['content'] = str_replace($keyword[0],$keyword[1],$get_data['content']);
			}
			
			$aReturn[$key] = $get_data;
		}
		return $aReturn;
	}
}