<?php
class MessageModel extends Model{
	
	/**
	*	根据用户ID获取此用户发送的留言
	**/
	public function getSendMessageByUserId($uid){
		$where['user_id'] = $uid;
		$message_res = $this->where($where)->order('add_time DESC')->select();
		return $message_res;
	}
	
	/**
	*	根据用户ID获取此用户收到的留言
	**/
	public function getIncomeMessageByUserId($uid){
		$where['to_user_id'] = $uid;
		$message_res = $this->where($where)->order('add_time DESC')->select();
		return $message_res;
	}
	
	/**
	*	根据用户ID获取此用户未读留言
	**/
	public function getIncomeMessageNoReadByUserId($uid){
		$where['is_read'] = 0;
		$where['to_user_id'] = $uid;
		$message_res = $this->where($where)->order('add_time DESC')->select();
		return $message_res;
	}
}