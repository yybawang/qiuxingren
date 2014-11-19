<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends HomeAction {
	/* public function _initialize(){
		//存客户 IP 入库
		$ip_data['add_time'] = time();
		$ip_data['ip'] = get_client_ip();
		M('ip')->add($ip_data);
	} */

    public function index(){
		$article = M('article');
		$image = M('image');
		$comment = M('comment');
		$where['is_show'] = 1;
		$where['add_time'] = array('ELT',session('now'));
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.article_id DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','刚刚发生的糗事__糗星人网站首页');
		$this->display();
    }
	
	// 方法有 hot_8热门  hot精华  week精华一周  month精华一月  imgrand硬菜  pic时令  send投稿
	public function hot_8(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		// 一小时是3600秒，一天是 86400 秒
		$time = 3600*8;	//要减去的秒数
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.up DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','8小时内精华尴尬事__糗星人网站');
		
		$this->display('index');
	}
	public function hot(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$time = 3600*24;	//要减去的秒数
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.up DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
				}
				$res[$key]['former_user_id'] = $u_res['user_id'];
				$res[$key]['former_user_name'] = $u_res['user_name'];
			}
		}
		if(IS_AJAX){
			$this->ajaxReturn($res,"请求成功",1);
		}
		$this->assign('content',$res);
		$this->assign('title','一天内尴尬事__糗星人网站');
		
		$this->display('index');
	}
	public function week(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$time = 3600*24*7;	//要减去的秒数
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.up DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','一周内尴尬事__糗星人网站');
		
		$this->display('index');
	}
	public function month(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$time = 3600*24*30;	//要减去的秒数
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_where($where);
		$res = $article->where($where)->order(C('DB_PREFIX').'article.up DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','一月内尴尬事__糗星人网站');
		
		$this->display('index');
	}
	public function imgrand(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$time = 3600*24;	//24小时内
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_join($where,'right join __IMAGE__ on __IMAGE__.in_article_id = __ARTICLE__.article_id');
		$res = $article->join('right join __IMAGE__ on __IMAGE__.in_article_id = __ARTICLE__.article_id')->where($where)->order(C('DB_PREFIX').'article.up DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$data['article_id'])->select();
			$res[$key]['image'] = $img;
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','有图有真相之硬菜__糗星人网站');
		
		$this->display('index');
	}
	public function pic(){
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$time = 3600*5;	//5小时内
		$time = time() - $time;
		$where['is_show'] = 1;
		$where['add_time'] = array('BETWEEN',array($time,session('now')));
		$this->pages_join($where,'right join __IMAGE__ on __IMAGE__.in_article_id = __ARTICLE__.article_id');
		$res = $article->join('right join __IMAGE__ on __IMAGE__.in_article_id = __ARTICLE__.article_id')->where($where)->order(C('DB_PREFIX').'article.article_id DESC')->limit(C('limit_min'),C('limit'))->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$data['article_id'])->select();
			$res[$key]['image'] = $img;
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
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
		$this->assign('title','有图有真相之时令__糗星人网站');
		
		$this->display('index');
	}
	/**
	*	单独浏览页
	**/
	public function single(){
		$a_id = $_GET['article'];
		if(empty($a_id)){
			$this->error('参数错误');
			exit();
		}
		$article = M('article');
		$comment = M('comment');
		$image = M('image');
		$a_res = $article->where('article_id = '.$a_id)->find();
		$img_res = $image->where('in_article_id = '.$a_id)->select();
		$a_res['image'] = $img_res;
		//如果是自己网站的用户
		if($a_res['user_id'] > 0 && $a_res['former_id'] == 0){
			$u_res = M("user")->where('user_id = '.$a_res['user_id'])->find();
			if(empty($u_res['pic'])){
				$a_res['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
			}
			$a_res['former_user_id'] = $u_res['user_id'];
			$a_res['former_user_name'] = $u_res['user_name'];
		}
		//评论数量
		$a_res['comment_count'] = $comment->where('article_id = '.$a_id)->count();
		$this->assign('data',$a_res);
		$this->assign('title','糗事'.$a_id.'__糗星人网站');
		$this->display();
	}
	
	/**
	*	删除文章
	**/
	public function del(){
		$article_id = $_POST['article_id'];
		if(!$article_id){
			$this->ajaxReturn('','文章ID为空',0);
		}else{
			$article = M('article');
			$save['is_show'] = 0;
			$line = $article->where('article_id = '.$article_id)->save($save);
			if($line){
				$this->ajaxReturn('','删除成功',1);
			}else{
				$this->ajaxReturn('','服务器错误',0);
			}
		}
	}
	
	
	/**
	*	显示留言
	**/
	public function comment(){
		$data['article_id'] = $_POST['article_id'];
		$comment = M('comment');
		$res = $comment->where($data)->order(C('DB_PREFIX').'comment.comment_time ASC')->select();
		foreach($res as $key => $value){
			if($value['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = '/public/images/default_pic.jpg';
				}else{
					$res[$key]['pic'] = $u_res['pic'];
				}
				$res[$key]['user_name'] = $u_res['user_name'];
				$res[$key]['user_id'] =  $u_res['user_id'];
			}else{
				$res[$key]['pic'] = '/public/images/default_pic.jpg';
				$res[$key]['user_name']  ='匿名用户';
				$res[$key]['user_id']  = 0;
			}
		}
		
		$this->ajaxReturn($res,'json');
	}
	public function add_comment(){
		$data['comment_content'] = $_POST['comment'];
		if(empty($data['comment_content'])){
			$json['add'] = false;
			$this->ajaxReturn($json);
			exit();
		}else{
			$comment = M('comment');
			$u_info = session('tsuser');
			$user_id = $u_info['userid'];
			if($user_id <= 0){
				$data['user_id'] = 0;
				$json['user_id'] = 0;
				$json['pic'] = '/public/images/default_pic.jpg';
				$json['user_name'] = '匿名用户';
			}else{
				$user = M('user');
				$res = $user->where('user_id = '.$user_id)->find();
				if(empty($res['pic'])){
					$res['pic'] = '/public/images/default_pic.jpg';
				}
				$json['user_id'] = $res['user_id'];
				$json['pic'] = $res['pic'];
				$json['user_name'] = $res['user_name'];
				$data['user_id'] = $user_id;
			}
			$data['article_id'] = $_POST['article_id'];
			$data['comment_time'] = time();
			$res = $comment->data($data)->add();
			if($res >0){
				$json['add'] = 1;
			}else{
				$json['add'] = false;
			}
			$this->ajaxReturn($json,'json');
		}
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
		$this->assign('article_num',$article_num);
		$this->assign('page_num',$page_num);
		$this->assign('this_page',$page);
	}
	function pages_join($where,$join){
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
		
		$article_num = $article->join($join)->where($where)->count();	//得到总条数
		$page_num = $article_num/C('PAGE_ARTICLE_NUM');	//得到页数
		$this->assign('article_num',$article_num);
		$this->assign('page_num',$page_num);
		$this->assign('this_page',$page);
	}
	public function up(){
		$a_id = $_POST['article_id'];
		$updown = M('article');
		$res = $updown->where('article_id = '.$a_id)->setInc('up');
		$res > 0 ? $value = '1' : $value = 'error';
		$this->ajaxReturn($value);
	}
	public function down(){
		$a_id = $_POST['article_id'];
		$updown = M('article');
		$res = $updown->where('article_id = '.$a_id)->setDec('down');
		$res > 0 ? $value = '1' : $value = 'error';
		$this->ajaxReturn($value);
	}
	public function report(){
		if(empty($_POST['article_id']) && empty($_POST['text'])){
			$error = 'empty';
			$this->ajaxReturn($error);
			exit;
		}
		$message = M('message');
		$data['user_id'] = session('user_id') ? session('user_id') : 0;
		$data['add_time'] = time();
		$data['add_ip'] = get_client_ip();
		$data['to_user_id'] = 1;		//给管理员的
		$data['content'] = '举报了文章ID为 '.$_POST['article_id'].' 的文章，动作为：'.$_POST['text'];
		$id = $message->data($data)->add();
		$id ? $error = 'success' : $error = 'error';
		$this->ajaxReturn($error);
	}
	public function move_zone(){
		if(empty($_POST['article_id']) && empty($_POST['zone'])){
			$error = 'empty';
			$this->ajaxReturn($error);
			exit;
		}
		$article = M('article');
		$where['article_id'] = $_POST['article_id'];
		$data['zone'] = $_POST['zone'];
		$id = $article->data($data)->where($where)->save();
		$id ? $error = 'success' : $error = 'error';
		$this->ajaxReturn($error);
	}
	public function search(){
		if(empty($_POST['keyword'])){
			$this->error("没有关键字");
			exit;
		}
		$article = M('article');
		$image = M('image');
		$comment = M('comment');
		$this->pages_where("is_show =1 and content like '%".$_POST['keyword']."%'");
		$res = $article->where("is_show =1 and content like '%".$_POST['keyword']."%'")->select();
		foreach($res as $key => $value){
			$data['article_id'] = $value['article_id'];
			$res[$key]['comment_count'] = $comment->where($data)->count();
			$img = $image->where('in_article_id = '.$res[$key]['article_id'])->select();
			if($img){
				$res[$key]['image'] = $img;
			}
			//如果是自己网站的用户
			if($res[$key]['former_id'] == 0 && $res[$key]['user_id'] > 0){
				$u_res = M("user")->where('user_id = '.$value['user_id'])->find();
				if(empty($u_res['pic'])){
					$res[$key]['pic'] = __ROOT__.'/Public/public/images/default_pic.jpg';
				}
				$res[$key]['former_user_id'] = $u_res['user_id'];
				$res[$key]['former_user_name'] = $u_res['user_name'];
			}
		}
		$this->assign('content',$res);
		$this->assign('title','查找糗事__糗星人网站首页');
		$this->display('index');
	}
}















