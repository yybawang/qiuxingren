<?php
class ArticleModel extends Model {
	
	/**
	*	获取文章信息
	**/
	public function get_article($id='',$limit_min=''){
		$where =array();
		if(!empty($id)){
			$where['article_id'] = $id;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		$data = $this->where($where)->limit($limit)->order('article_id DESC')->select();
		return $data;
	}
}