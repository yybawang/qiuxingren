<?php
class HomeAction extends Action {
	
	// action 中保存用户基本信息
	public $G_u = array();
	/**
	*	全局登陆检测更新，统一用cookie方法存用户信息，去掉session
	**/
	public function _initialize(){
		$session_nowtime = session('now');
		if(empty($session_nowtime)){
			session('now',time(),3600);		//保存1个小时
		}
	
		$user_cookie = cookie('user_cookie');	//cookies 信息有array('user_id','user_name','email');
		if(!empty($user_cookie)){
			$uid = $user_cookie['user_id'];
			$dU = D('User');
			/* $last['last_log_time'] = time();
			$last['last_log_ip'] = get_client_ip();
			$dU->where('user_id = '.$uid)->data($last)->save();			//更新最后登陆时间和IP
			$dU->where('user_id = '.$uid)->setInc('logins');				//更新最后登陆时间和IP 
			*/
			$this->G_u = $dU->getUserInfoById($uid);
			//赋值全局变量到模板
			$this->assign('G_u',$this->G_u);
		}
		
		define('__UPLOAD__',FILE_DIR.'/Public');
		define('__PUBLIC__',__ROOT__.'/Public');
	}
	
	/**
	*	处理分页传值和 limit
	**/
	protected function format_limit(){
		$get_page = I('request.page');
		if($get_page <= 1){
			$page =  0;
		}else{
			$page =  $get_page-1;
		}
		$limit = intval($page) * intval(C('LIMIT')).','.C('LIMIT');
		//返回类似 20,40 的字符串
		return $limit;
	}
	
	
	/**
	*	通用成功/失败 ajax 方法
	**/
	protected function _ajax_success($info = '',$data = null){
		empty($info) ? $info = '成功' : '';
		$this->ajaxReturn($data,$info,1);
	}
	protected function _ajax_error($info = '',$data = null){
		empty($info) ? $info = '失败' : '';
		$this->ajaxReturn($data,$info,0);
	}
	
	/**
	*	通用 action 内成功失败方法
	**/
	protected function _success($info = '',$data = null){
		empty($info) ? $info = '成功' : '';
		$return['info'] = $info;
		$return['data'] = $data;
		$return['status'] = 1;
		return $return;
	}
	protected function _error($info = '',$data = null){
		empty($info) ? $info = '失败' : '';
		$return['info'] = $info;
		$return['data'] = $data;
		$return['status'] = 0;
		return $return;
	}
	
	protected function upload_image($save_path){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 4098000 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath = $save_path;// 设置附件上传目录  
		if(!$upload->upload()) {
			// 上传错误提示错误信息        
			return $this->_error($upload->getErrorMsg());    
		}else{
			// 上传成功
			$data =  $upload->getUploadFileInfo();
			return $this->_success('',$data);
		}
	}
	
	/**
	*	前台分页,HTML 直接写在这里
	*	@param1		总数量
	**/
	protected function page_dom($nPageCount){
		$page = ceil($nPageCount/C('LIMIT'));	//总页数
		$this_page = intval($_GET['page']);		//当前页
		$this_page = empty($this_page) ? 1 : $this_page;
		$aParseUrl = parse_url(__SELF__);
		//分解参数
		$sLink = str_replace('.html','',$aParseUrl['path']).'?';
		$sParam = preg_replace('/[\&\?]?page=.*\&?/','',$aParseUrl['query']);
		//生成连接
		if(empty($sParam)){
			$sLink .= 'page=';
		}else{
			$sLink .= $sParam;
			$sLink .= '&page=';
		}
		
		//生成DOM
		if($page > 1){
			$sPageDom = '<div  class="y_pager"><ul>';
			//上一页
			if($this_page <= 1){
				$sPageDom .= '<li><a class="disabled">&laquo;</a></li>';
			}else{
				$sPageDom .= '<li><a href="'.$sLink.($this_page-1).'">&laquo;</a></li>';
			}
			
			$is_missing_page = false;
			$is_missing_this_page = 0;
			//中间
			for($i=1;$i<=$page;$i++){
				if($i>2 && $i<$page){
					if($i >= $this_page-1 && $i<= $this_page+2){
						$is_missing_this_page++;
						//
						if($i != 3 && $is_missing_this_page === 1){
							$sPageDom .= '<li><a>·····</a></li>';
						}
						
						if($i == $this_page){
							$sPageDom .= '<li><a class="active" href="'.$sLink.$i.'">'.$i.'</a></li>';
						}else{
							$sPageDom .= '<li><a href="'.$sLink.$i.'">'.$i.'</a></li>';
						}
					}
					$is_missing_page = true;
					continue;
				}
				
				if($is_missing_page){
					$sPageDom .= '<li><a>·····</a></li>';
					$is_missing_page[1] = false;
				}
				
				if($i == $this_page || (empty($this_page) && $i == 1)){
					$sPageDom .= '<li><a class="active" href="'.$sLink.$i.'">'.$i.'</a></li>';
				}else{
					$sPageDom .= '<li><a href="'.$sLink.$i.'">'.$i.'</a></li>';
				}
				
			}
			//下一页
			if($this_page >= $page){
				$sPageDom .= '<li><a class="disabled">&raquo;</a></li>';
			}else{
				$sPageDom .= '<li><a href="'.$sLink.($this_page+1).'">&raquo;</a></li>';
			}
			$sPageDom .= '<li><input type="text" placeholder="数字" name="page" /></li><li><input type="button" value="跳　转"  /></li></ul></div>';
		}
		return $sPageDom;
    }
	

	
	
	/**
	*	传入数量值返回总数和页数
	*	@return array
	**/
	protected function assign_pages($num){
		$return['num'] = $num;
		$return['page_num'] = $num / C('LIMIT');
		$this->assign('pages',$return);
	}
	
	//判断是否是ajax请求
	protected function return_data($article){
		if(IS_AJAX){
			$this->_ajax_success('',$article);
		}else{
			$this->assign('article_data',$article);
		}
	}
	
	
}