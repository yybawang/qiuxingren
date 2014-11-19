<?php
class UserModel extends Model{
	/**
	*	根据 email 获取用户表信息
	*/
	public function getUserInfoByEmail($email){
		$user_info = $this->where('email="'.$email.'"')->find();
		return $user_info;
	}
	
	/**
	*	根据用户 id 获取用户信息
	**/
	public function getUserInfoById($uid){
		$user_info = $this->where('user_id='.$uid)->find();
		return $user_info;
	}
}