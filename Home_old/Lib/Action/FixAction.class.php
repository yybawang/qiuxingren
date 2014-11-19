<?php
// 本类由系统自动生成，仅供测试用途
class FixAction extends HomeAction {
    public function index(){
		$article = M('article');
		$res = $article->limit(6600,10000)->select();
		foreach($res as $value){
			$data['zone'] = 0;
			//查找出内容属于哪个版块
			foreach(C('z1.keyword') as $c_key => $c_value){
				$len = stripos($value['content'],$c_value);
				if($len !== false){
					$data['zone'] = 1;
					break;
				}
			}
			if($data['zone'] == 0){
				foreach(C('z2.keyword') as $c_key => $c_value){
					$len = stripos($value['content'],$c_value);
					if($len !== false){
						$data['zone'] = 2;
						break;
					}
				}
			}
			if($data['zone'] == 0){
				foreach(C('z3.keyword') as $c_key => $c_value){
					$len = stripos($value['content'],$c_value);
					if($len !== false){
						$data['zone'] = 3;
						break;
					}
				}
			}
			$row = $article->data($data)->where('article_id = '.$value['article_id'])->save();
			if($row){
				$this->show('把ID为'.$value['article_id'].'的文章版区改为'.$data['zone'].'<br />','utf-8');
			}
		}
		$this->assign('title','修复版区的信息_糗星人');
    }
}
?>