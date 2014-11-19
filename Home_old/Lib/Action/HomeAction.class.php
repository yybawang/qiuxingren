<?php
class HomeAction extends Action {
	public function _initialize(){
		$cookie_email = cookie('email');
		if(!empty($cookie_email)){
			$user_info = D('User')->getUserInfoByEmail($cookie_email);
			$session = array(
				'userid' => $user_info['user_id'],
				'username' => $user_info['user_name'],
			);
			session("tsuser",$session);
			$saas = M('user');
			$last['last_log_time'] = time();
			$last['last_log_ip'] = get_client_ip();
			$saas->where('user_id = '.$uid)->data($last)->save();			//更新最后登陆时间和IP
			$saas->where('user_id = '.$uid)->setInc('logins');			//更新最后登陆时间和IP
		}
	}
}