<?php
/**
*	后台
**/
class AdminAction extends Action{
	public function _initialize(){
		//这里做必须登录的验证
		$admin_id = session('admin_id');
		if($admin_id != 1){
			$this->display('User/login');
			exit;
		}
	}
	
	public function param_page(){
		$page = I('get.page');
		if($page <= 1){
			return 0;
		}else{
			return ($page-1);
		}
	}
	
	
	/**
	*	前台分页,HTML 直接写在这里
	**/
	protected function page_dom($nPageCount){
		$page = ceil($nPageCount/C('LIMIT'));	//总页数
		$this_page = intval($_GET['page']);		//当前页
		$this_page = empty($this_page) ? 1 : $this_page;
		$aParseUrl = parse_url(__SELF__);
		//分解参数
		$sLink = str_replace('.html','',$aParseUrl['path']).'?';
		$sParam = preg_replace('/\&?page=\d*\&?/','',$aParseUrl['query']);
		
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
				$sPageDom .= '<li><a>&laquo;</a></li>';
			}else{
				$sPageDom .= '<li><a href="'.$sLink.($this_page-1).'">&laquo;</a></li>';
			}
			
			$is_missing_page = false;
			$is_missing_this_page = 0;
			//中间
			for($i=1;$i<=$page;$i++){
				if($i>5 && $i<$page){
					if($i >= $this_page-3 && $i<= $this_page+3){
						$is_missing_this_page++;
						//
						if($i != 6 && $is_missing_this_page === 1){
							$sPageDom .= '<li><a>······</a></li>';
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
					$sPageDom .= '<li><a>······</a></li>';
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
				$sPageDom .= '<li><a>&raquo;</a></li>';
			}else{
				$sPageDom .= '<li><a href="'.$sLink.($this_page+1).'">&raquo;</a></li>';
			}
			$sPageDom .= '<li><input type="text" name="page" /></li><li><input type="button" value="跳　转"  /></li></ul></div>';
		}
		return $sPageDom;
    }
	
	
	protected function iframe_menu(){
		$menus = array(
			array(
				'title'	=> '后台中心',
				'class'	=> 'home',
				'url'	=> '__GROUP__/index/iframe_index',
				'child' => array(
					array(
						'title'		=> '后台首页',
						'url'	 	=> '__GROUP__/index/iframe_index',
					),
					array(
						'title'		=> '后台设置',
						'url'	 	=> '__GROUP__/index/setting',
					),
				),
			),
			array(
				'title'	=> '用户管理',
				'class'	=> 'user',
				'url'	=> '__GROUP__/user/view',
				'nums'	=> D('User')->get_user_count(),
				'child'	=> array(
					array(
						'title'	=> '用户查看',
						'url'	=> '__GROUP__/user/view',
					),
					array(
						'title'	=> '添加用户',
						'url'	=> '__GROUP__/user/add',
					),
				),
			),
			array(
				'title'	=> '信息管理',
				'class'	=> 'log',
				'url'	=> '__GROUP__/message/view_fankui',
				'nums'	=> D('Message')->get_fankui_count(),
				'child'	=> array(
					array(
						'title'	=> '留言反馈',
						'url'	=> '__GROUP__/message/view_fankui',
					),
				),
			),
			array(
				'title'	=> '文章管理',
				'class'	=> 'article',
				'url'	=> '__GROUP__/article/view',
				'nums'	=> D('Article')->get_article_count(),
				'child'	=> array(
					array(
						'title'	=> '文章查看',
						'url'	=> '__GROUP__/article/view',
					),
				),
			),
			array(
				'title'	=> '图片管理',
				'class'	=> 'image',
				'url'	=> '__GROUP__/image/view',
				'nums'	=> D('Image')->get_image_count(),
				'child'	=> array(
					array(
						'title'	=> '网站图片',
						'url'	=> '__GROUP__/image/view',
					),
					array(
						'title'	=> '抓取的图片(链接)',
						'url'	=> '__GROUP__/image/qiubai_view',
					),
				),
			),
			array(
				'title'	=> 'IP 管理',
				'class'	=> 'ip',
				'nums'	=> D('Ip')->get_ip_count(),
				'url'	=> '__GROUP__/ip/view',
				'child'	=> array(
					array(
						'title'	=> '流量 IP',
						'url'	=> '__GROUP__/ip/view',
					),
				),
			),
			array(
				'title'	=> '抓取规则',
				'class'	=> 'terminal',
				'url'	=> '__GROUP__/rule/view',
				'child'	=> array(
					array(
						'title'	=> '规则查看',
						'url'	=> '__GROUP__/rule/view',
					),
					array(
						'title'	=> '抓取间隔',
						'url'	=> '__GROUP__/rule/timeout',
					),
				),
			),
		);
		return $menus;
	}
}
?>