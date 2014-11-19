<?php
class ArticleModel extends Model {
	
	/**
	*	获取用户表下所有用户
	*	@param1	用户ID，如果有就做筛选，否则显示全部
	*	@param2	查数据起始位置
	**/
	public function get_article($aid = '',$limit_min = ''){
		$where =array();
		if(!empty($aid)){
			$where['id'] = $aid;
		}
		$limit = '';
		if($limit_min !== ''){
			$limit = $limit_min.','.C('LIMIT');
		}
		$article_data = $this->where($where)->order('id DESC')->limit($limit)->select();
		return $article_data;
	}
	
	
	/**
	*	获取文章总数量
	**/
	public function get_article_count(){
		$article_count = M('article')->count();
		return $article_count;
	}
}