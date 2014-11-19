<?php
class ArticleModel extends Model {
	
	/**
	*	获取文章信息
	**/
	public function get_article($id='',$limit=''){
		$where =array();
		if(!empty($id)){
			$where['id'] = $id;
		}else{
			$where['is_show'] = 1;
			//判断是否规定某时间内
			$where['add_time'] = array('ELT',session('now'));
		}
		
		$data = $this->where($where)->order('id DESC')->limit($limit)->select();
		$data = $this->getImageByArticle($data);
		return $data;
	}
	
	
	/**
	*	根据 uid 获取文章
	**/
	public function getArticleByUserId($uid){
		$where['user_id'] = $uid;
		$data = $this->where($where)->order('add_time DESC')->select();
		$data = $this->getImageByArticle($data);
		return $data;
	}
	
	private function getImageByArticle($data){
		$dI = D('Image');
		$dU = D('User');
		$dC = D('Comment');
		foreach($data as $key => $val){
			//获取文章对应图片
			$data[$key]['image'] = $dI->getImageByAId($val['id']);
			if($val['user_id'] > 0){
				$user_info = $dU->getUserInfoById($val['user_id']);
				$article_res[$key]['former_user_id'] = $user_info['user_id'];
				$article_res[$key]['former_user_name'] = $user_info['user_name'];
				$article_res[$key]['former_user_email'] = $user_info['email'];
				$article_res[$key]['pic'] = $user_info['pic'];
			}
			//评论数量
			$article_res[$key]['comment_count'] = $dC->getCommentCount($val['id']);
		}
		return $data;
	}
	
	/**
	*	随机查询出一条待审核文章
	**/
	public function getArticleByRand(){
		$where['is_show'] = 0;
		$data = $this->where($where)->order('rand()')->limit('1')->select();
		$data = $this->getImageByArticle($data);
		return $data;
	}
}