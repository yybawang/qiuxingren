<?php
class ImageAction extends AdminAction{
	public function index(){
		$this->view();
	}
	
	/**
	*	浏览图片
	**/
	public function view(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$data = D('Image')->get_image('',$limit);
		
		$count = D('Image')->get_image_count();
		$page_dom = $this->page_dom($count);
		$this->assign('pager',$page_dom);
		
		$this->assign('images',$data);
		$this->display();
	}
	
	/**
	*	浏览糗百图片
	**/
	public function qiubai_view(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$data = D('Image')->get_qiubai_image('',$limit);
		
		$count = D('Image')->get_qiubai_image_count();
		$page_dom = $this->page_dom($count);
		$this->assign('pager',$page_dom);
		
		$this->assign('images',$data);
		$this->display();
	}
	
	
	/**
	*	划过鼠标获取文章内容
	**/
	public function hover_article(){
		$aid = I('post.aid');
		$a_res = D('Article')->get_article($aid);
		if(is_array($a_res)){
			$this->ajaxReturn($a_res[0]['content'],'成功',1);
		}
	}
	
}
