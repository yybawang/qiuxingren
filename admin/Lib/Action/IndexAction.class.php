<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends AdminAction {

	//加载iframe框架
    public function index(){
		$menus = $this->iframe_menu();
		$this->assign('menus',$menus);
		$this->assign('title','糗星人后台--晏勇');
		$this->display('public/iframe_index');
    }
	
	/**默认首页**/
	public function iframe_index(){
		$menus = $this->iframe_menu();
		$this->assign('menus',$menus);
		$this->display('index');
	}
	
	/**
	*	设置中心
	**/
	public function setting(){
		
	}
	
	/**
	*	清除缓存（后台加前台）
	**/
	public function clear_temp(){
		$home_temp = deldir(FILE_ROOT.'/Home/Runtime');
		$admin_temp = deldir(FILE_ROOT.'/admin/Runtime');
		// system('del /s /f /q '.FILE_ROOT.'\Home\Runtime');
		$this->ajaxReturn('','清理完成',1);
	}
	
	/**
	*	处理多选删除
	**/
	public function double_del(){
		$sIds = I('post.ids');
		$model = I('post.model');
		$field = I('post.field');
		
		$where[$field] = array('in',$sIds);
		M($model)->where($where)->delete();
		$this->ajaxReturn('','',1);
	}
	
	
}