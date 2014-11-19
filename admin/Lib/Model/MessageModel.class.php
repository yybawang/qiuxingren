<?php
class MessageModel extends Model{
	
	
	public function get_fankui($iid= '',$limit_min = ''){
		$where =array('to_user_id'=>1);
		if(!empty($iid)){
			$where['message_id'] = $iid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		
		$data = $this->where($where)->limit($limit)->order('message_id DESC')->select();
		return $data;
	}
	
	/**
	*	获取网站的反馈留言(给用户管理员的)
	**/
	public function get_fankui_count(){
		$count = M('message')->where('to_user_id = 1')->count();
		return $count;
	}
	
	/**管理员回复用户的反馈**/
	public function add_fankui($uid,$content){
		$data['user_id'] = 1;
		$data['to_user_id'] = $uid;
		$data['content'] = $content;
		$data['add_time'] = time();
		$data['add_ip'] = get_client_ip();
		$line = $this->add($data);
		return $line;
	}
}
