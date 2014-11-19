<?php
class FollowModel extends Model{
	
	/**
	*	根据用户 ID 来获取粉丝
	**/
	public function getFollowersByUserId($uid){
		$where['user_id_follow'] = $uid;
		$data = $this->field('user_id')->where($where)->order('add_time DESC')->select();	//返回关注传值uid的用户ID
		return $data;
	}
	
	/**
	*	根据用户 ID 来获取关注用户
	**/
	public function getFollowingsByUserId($uid){
		$where['user_id'] = $uid;
		$data = $this->field('user_id_follow as user_id')->where($where)->order('add_time DESC')->select();
		return $data;
	}
}