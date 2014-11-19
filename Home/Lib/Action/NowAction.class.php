<?php
class NowAction extends HomeAction{
	
	private $dA = '';		//D方法实例化 article 表
	private $dI = '';		//D方法实例化 image 表
	private $dC = '';		//D方法实例化 comment 表
	private $dU = '';		//D方法实例化 user 表
	
	private $table_a = '';
	private $table_i = '';
	
	private $last = '';
	
	private $get_site = 'http://www.qiushibaike.com/';
	
	public function _initialize(){
		parent::_initialize();
		import('@.Widget.phpQueryOne');
		$this->dA = D('Article');
		$this->dI = D('Image');
		$this->dC = D('Comment');
		$this->dU = D('User');
		
		$this->table_a = C('DB_PREFIX').'article';
		$this->table_i = C('DB_PREFIX').'image';
		
		if(isset($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}else{
			$page = 1;
		}
		$this->last = 'page/'.$page;
	}
	
	public function index(){
		$this->late();
	}
	
	//抓取最新
	public function late(){
		$article = $this->get_article($this->get_site.'late/'.$this->last);
		$this->return_data($article);
		$this->assign('title','实时最新__'.C('WEB_NAME'));
		$this->display('Article/index_201408');
	}
	
	/****/
	public function hot_8(){
		$article = $this->get_article($this->get_site.'8hr/'.$this->last);
		
		$this->return_data($article);
		$this->assign('title','实时8小时内精华__'.C('WEB_NAME'));
		$this->display('Article/index_201408');
	}
	
	/****/
	public function hot_24(){
		$article = $this->get_article($this->get_site.'hot/'.$this->last);
		
		$this->return_data($article);
		$this->assign('title','实时24小时内精华__'.C('WEB_NAME'));
		$this->display('Article/index_201408');
	}
	
	/****/
	public function pic(){
		$article = $this->get_article($this->get_site.'pic/'.$this->last);
		
		$this->return_data($article);
		$this->assign('title','实时有图有真相之最新__'.C('WEB_NAME'));
		$this->display('Article/index_201408');
	}
	
	/****/
	public function imgrank(){
		$article = $this->get_article($this->get_site.'imgrank/'.$this->last);
		
		$this->return_data($article);
		$this->assign('title','实时有图有真相之精华__'.C('WEB_NAME'));
		$this->display('Article/index_201408');
	}
	
}