<?php
// 本类由系统自动生成，仅供测试用途
class ZoneAction extends HomeAction {
    public function index(){
		$this->z1();
    }
	
	//求祝福区
	public function z1(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$where['is_show'] = 1;
		$where['zone'] = 1;
		$where['add_time'] = array('ELT',session('now'));
		if(isset($_GET['by'])){
			$order = $_GET['by'];
		}else{
			$order = 'add_time';
		}
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.'.$order.' DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果名字不为空才加上用户头像
			//如果是自己网站的用户
			if($res[$key]['former_id'] > 0 && $res[$key]['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
				}
				$res[$key]['former_user_id'] = $u_res['user_id'];
				$res[$key]['former_user_name'] = $u_res['user_name'];
			}
		}
		if(IS_AJAX){
			foreach($res as $key => $value){
				$res[$key]['add_time'] = date("Y-m-d H:i:s",$value['add_time']);
			}
			$this->ajaxReturn($res,"请求成功",1);
		}
		$this->assign('content',$res);
		$this->assign('title','求祝福区__糗星人网站');
		$this->display('index');
	}
	//XXOO区
	public function z2(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$where['is_show'] = 1;
		$where['zone'] = 2;
		$where['add_time'] = array('ELT',session('now'));
		if(isset($_GET['by'])){
			$order = $_GET['by'];
		}else{
			$order = 'add_time';
		}
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.'.$order.' DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果名字不为空才加上用户头像
			//如果是自己网站的用户
			if($res[$key]['former_id'] > 0 && $res[$key]['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
				}
				$res[$key]['former_user_id'] = $u_res['user_id'];
				$res[$key]['former_user_name'] = $u_res['user_name'];
			}
		}
		if(IS_AJAX){
			foreach($res as $key => $value){
				$res[$key]['add_time'] = date("Y-m-d H:i:s",$value['add_time']);
			}
			$this->ajaxReturn($res,"请求成功",1);
		}
		$this->assign('content',$res);
		$this->assign('title','XXOO区__糗星人网站');
		$this->display('index');
	}
	public function z3(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$where['is_show'] = 1;
		$where['zone'] = 3;
		$where['add_time'] = array('ELT',session('now'));
		if(isset($_GET['by'])){
			$order = $_GET['by'];
		}else{
			$order = 'add_time';
		}
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.'.$order.' DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] > 0 && $res[$key]['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
				}
				$res[$key]['former_user_id'] = $u_res['user_id'];
				$res[$key]['former_user_name'] = $u_res['user_name'];
			}
		}
		if(IS_AJAX){
			foreach($res as $key => $value){
				$res[$key]['add_time'] = date("Y-m-d H:i:s",$value['add_time']);
			}
			$this->ajaxReturn($res,"请求成功",1);
		}
		$this->assign('content',$res);
		$this->assign('title','爆照求带走区__糗星人网站');
		$this->display('index');
	}
	
	
	function pages_where($where='1=1'){
		$article = M('article');
		$page = $_REQUEST['page'];
		if(empty($page) || $page<=1){
			$page = 1;
			C('limit',C('PAGE_ARTICLE_NUM'));
			C('limit_min','0');
		}else{
			C('limit',C('PAGE_ARTICLE_NUM'));
			C('limit_min',($page-1)*C('PAGE_ARTICLE_NUM'));
		}
		$article_num = $article->where($where)->count();	//得到总条数
		$page_num = $article_num/C('PAGE_ARTICLE_NUM');	//得到页数
		$this->assign('aiticle_num',$article_num);
		$this->assign('page_num',$page_num);
		$this->assign('this_page',$page);
	}
	
}
?>