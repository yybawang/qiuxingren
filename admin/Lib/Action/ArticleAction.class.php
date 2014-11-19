<?php

class ArticleAction extends AdminAction{
	public function index(){
		$this->view();
	}
	
	/**
	*	文章查看
	**/
	public function view(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$article_data = D('Article')->get_article('',$limit);
		foreach($article_data as $key => $val){
			if(!empty($val['add_time'])){$article_data[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);}
			if(!empty($val['check_time'])){$article_data[$key]['check_time'] = date('Y-m-d H:i:s',$val['check_time']);}
			$article_image = M('image')->where('article_id = '.$val['id'])->select();
			$article_data[$key]['images'] = $article_image;
			switch($val['zone']){
				case '0': $article_data[$key]['zone_text'] = '糗事';break;
				case '1': $article_data[$key]['zone_text'] = '求祝福';break;
				case '2': $article_data[$key]['zone_text'] = 'XXOO区';break;
				case '3': $article_data[$key]['zone_text'] = '求带走';break;
				default : $article_data[$key]['zone_text'] = '平常事';break;
			}
		}
		
		$article_count = D('Article')->get_article_count();
		$page_dom = $this->page_dom($article_count);
		$this->assign('pager',$page_dom);
		
		$this->assign('articles',$article_data);
		$this->display();
	}
}