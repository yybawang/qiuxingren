<?php
class IpModel extends Model{

	
	/**
	*	获取本站图片数量
	**/
	/**
	*	获取糗百图片链接
	**/
	public function get_ip($iid= '',$limit_min = ''){
		$where =array();
		if(!empty($iid)){
			$where['id'] = $iid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		
		$data = $this->where($where)->limit($limit)->order('id DESC')->select();
		return $data;
	}
	
	
	
	/**
	*	获取糗百图片数量
	**/
	public function get_ip_count(){
		$count = $this->count();
		return $count;
	}
	
}
