<?php
class ImageModel extends Model {
	/**
	*	获取图片信息
	**/
	public function get_image($id='',$limit=''){
		$where =array();
		if(!empty($id)){
			$where['article_id'] = $id;
		}else{
			$where['is_show'] = 1;
			$where['add_time'] = array('ELT',session('now'));
		}
		
		$data = $this->where($where)->order('id DESC')->limit($limit)->select();
		return $data;
	}
	
	/**
	*	根据 article_id 获取对应图片信息
	**/
	public function getImageByAId($aid){
		$data = $this->where('article_id = '.$aid)->select();
		return $data;
	}
}