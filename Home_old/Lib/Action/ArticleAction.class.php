<?php
class ArticleAction extends HomeAction{
	public function about(){
		$this->assign('title','关于我们_糗星人网站');
		$this->display();
	}
	public function state(){
		$this->assign('title','关于我们_糗星人网站');
		$this->display();
	}
	public function joinus(){
		$this->display();
	}
	public function proposal(){
		$this->display();
	}
	public function app(){
		$this->display();
	}
}
?>