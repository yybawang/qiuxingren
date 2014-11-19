<?php
class IndexAction extends HomeAction{
	public function index(){
		R('Article/index');
	}
	public function test(){
		
	}
	
	/**
	*	用户反馈！！
	**/
	public function proposal(){
		$user_id = user_id();
		
	}
}