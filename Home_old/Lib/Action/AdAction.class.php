<?php
// 本类由系统自动生成，仅供测试用途
class ADAction extends HomeAction {

	public function get_1(){
		$site = 'http://qiuxingren.com';
		empty($_GET['control']) ? $control = 'Ad' : '';
		empty($_GET['function']) ? $function = 'ad1' : '';
		$html = curl($site.'/index.php/'.$control.'/'.$function);
		echo $html;
	}
    public function index(){
		$this->display();
    }
	public function ad1(){
		$this->display('ad1');
	}
	public function ad2(){
		$this->display('ad2');
	}
	public function ad3(){
		$this->display('ad3');
	}
	public function ad4(){
		$this->display('ad4');
	}
}
?>