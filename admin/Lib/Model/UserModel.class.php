<?php
class UserModel extends Model {
	/**
	*	获取用户表下所有用户
	*	@param1	用户ID，如果有就做筛选，否则显示全部
	*	@param2	查数据起始位置
	**/
	public function get_user($uid = '',$limit_min = 0){
		$where =array();
		if(!empty($uid)){
			$where[C('DB_PREFIX').'user.user_id'] = $uid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		$user_data = $this->join('__USER_INFO__ on __USER__.user_id = __USER_INFO__.user_id')->where($where)->order(C('DB_PREFIX').'user.user_id DESC')->limit($limit)->select();
		return $user_data;
	}
	
	/**
	*	添加用户
	**/
	public function add_user(){
		
	}
	
	public function get_user_count(){
		$user_count = M('user')->count();
		return $user_count;
	}
}
?>