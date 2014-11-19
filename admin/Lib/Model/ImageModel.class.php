<?php
class ImageModel extends Model{

	
	/**
	*	获取本站图片数量
	**/
	/**
	*	获取糗百图片链接
	**/
	public function get_image($iid= '',$limit_min = ''){
		$where =array();
		if(!empty($iid)){
			$where['id'] = $iid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		
		$data = $this->where('image_link not like "http:%"')->where($where)->limit($limit)->order('id DESC')->select();
		return $data;
	}
	

	/**
	*	获取糗百图片链接
	**/
	public function get_qiubai_image($iid= '',$limit_min = ''){
		$where =array();
		if(!empty($iid)){
			$where['id'] = $iid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		
		$data = $this->where('image_link like "http:%"')->where($where)->limit($limit)->order('id DESC')->select();
		return $data;
	}
	





	

	/**
	*	获取本站图片数量
	**/
	public function get_image_count(){
		$count = $this->where('image_link not like "http:%"')->count();
		return $count;
	}
	
	
	/**
	*	获取糗百图片数量
	**/
	public function get_qiubai_image_count(){
		$count = $this->where('image_link like "http:%"')->count();
		return $count;
	}
	
}
