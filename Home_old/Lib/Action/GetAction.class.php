<?php
// 本类由系统自动生成，仅供测试用途
class GetAction extends HomeAction {
    public function index(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/late/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time());
			$this->display();
		}
    }
	public function hot_8(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/8hr/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 28800);
			$this->display('index');
		}
	}
	public function hot_24(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/hot/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400);
			$this->display('index');
		}
	}
	public function week(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/week/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400*7);
			$this->display('index');
		}
	}
	public function month(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/month/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400*24);
			$this->display('index');
		}
	}
	public function imgrank(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/imgrank/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html);
			$this->display('index');
		}
	}
	public function pic(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/pic/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html);
			$this->display('index');
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function go($html,$time){
		$hour = (int)date("H");					//获取小时
		switch($hour){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7: $timeout = 4000;break;
			case 8:
			case 9:
			case 10:
			case 11:
			case 12: $timeout = 2400;break;
			default: $timeout = 2400;
		}
		$this->assign('timeout',$timeout);
		$match = preg_list($html);
		$id = preg_id($match[0]);				//匹配原ID
		$content = preg_content($match[0]);		//匹配内容
		$thumb = preg_thumb($match[0]);			//匹配图片
		$up = preg_up($match[0]);
		$down = preg_down($match[0]);
		$author_name = preg_author_name($match[0]);
		$author_id = preg_author_id($match[0]);
		$author_pic = preg_author_pic($match[0]);
		
		//赋值到模板
		foreach($content as $key => $value){
			$get_data[] = array('content' => $value,'former_id' => $id[$key],'former_user_id'=>$author_id[$key],'former_user_name'=>$author_name[$key],'image_link' => $thumb[$key]);
		}
		$this->assign('content',$get_data);
		//插入数据库
		$article = M('article');
		$image = M('image');
		foreach($content as $key => $value){
			$result = $article->where('former_id = '.$id[$key])->select();
			if($result == null){
				//$data['content'] = $content[$key];
				$data['add_time'] = $time;
				$data['former_id'] = $id[$key];
				$data['former_user_name'] = $author_name[$key];
				$data['former_user_id'] = $author_id[$key];
				$data['pic'] = $author_pic[$key];
				$data['up'] = $up[$key];
				$data['down'] = $down[$key];
				$data['user_id'] = 0;
				$data['zone'] = 0;
				$rand = rand(1,10);
				//五分之一的概率把文章放入审核下
				if($rand <=2){
					$data['is_show'] = 0;
				}else{
					$data['is_show'] = 1;
				}
				//查找出内容属于哪个版块
				if($data['zone'] == 0){
					foreach(C('z1.keyword') as $c_key => $c_value){
						$len = stripos($content[$key],$c_value);
						if($len !== false){
							$data['zone'] = 1;
							break;
						}
					}
				}
				//如果为空，表示不是第一个板块，继续判断下一个
				if($data['zone'] == 0){
					foreach(C('z2.keyword') as $c_key => $c_value){
						$len = stripos($content[$key],$c_value);
						if($len !== false){
							$data['zone'] = 2;
							break;
						}
					}
				}
				if($data['zone'] == 0){
					foreach(C('z3.keyword') as $c_key => $c_value){
						$len = stripos($content[$key],$c_value);
						if($len !== false){
							$data['zone'] = 3;
							break;
						}
					}
				}
				//替换关键字--比如把 糗百 替换成 糗星人
				foreach(C('REPLACE_KEYWORDS') as $val){
					$data['content'] = str_replace($val[0],$val[1],$content[$key]);
				}
				$res = $article->data($data)->add();	//插入文章表
				//判断成功，而且还有图片，继续插入图片
				if($res){
					if($thumb[$key]){
						//<img src="http://pic.qiushibaike.com/system/pictures/6197/61974650/medium/app61974650.jpg" alt="看着看着就笑了">
						preg_match('/\"http.*?\"/is',$thumb[$key],$match_thumb);
						$match_thumb[0] = str_replace('"','',$match_thumb[0]);
						//dump($match_thumb[0],'utf-8');
						//$img_link = '/images/qxr_'.$res.'.jpg';
						//get_image($match_thumb[0],FILE_DIR.'/Public'.$img_link);		//不获取图片到本地，直接存入图片链接
						$img_data['in_article_id'] = $res;
						//$thumb[$key] = '/images/qxr'.$id[$key].'.jpg';
						//$img_data['image_link'] = $img_link;	//以文章ID命名
						$img_data['image_link'] = $match_thumb[0];	//以文章ID命名
						$img = $image->data($img_data)->add();
					}
				}
				
			}
		}
	}
}