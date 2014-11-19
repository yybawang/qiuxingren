<?php
class CommentModel extends Model {
	
	
	/**
	*	根据文章ID获取评论数量
	**/
	public function getCommentCount($aid){
		$data = $this->where('article_id='.$aid)->count();
		return $data;
	}
	
	/**
	*	根据文章 ID 来获取评论
	**/
	public function getCommentByAId($aid){
		$data = $this->where('article_id='.$aid)->order('add_time DESC')->select();
		if(empty($data)){
			return 0;
		}
		return $data;
	}
	
	/**
	*	根据用户 ID 来获取评论
	**/
	public function getCommentByUserId($uid){
		$data = $this->where('user_id='.$uid)->order('add_time DESC')->select();
		if(empty($data)){
			return 0;
		}
		return $data;
	}
}