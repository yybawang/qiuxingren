<?php
class UserModel extends Model{
	
	/**
	*	获取用户信息
	**/

	/**
	*	根据 email 获取用户表信息
	*/
	public function getUserInfoByEmail($email){
		$data = $this->where('email="'.$email.'"')->find();
		$user_info = M('user_info')->where('user_id = '.$data['user_id'])->find();		//详细信息
		$other_info = $this->getUserInfoOther($data['user_id']);
		$data = array_merge($data,$other_info,(array)$user_info);
		return $data;
	}
	
	/**
	*	根据用户 id 获取用户信息
	**/
	public function getUserInfoById($uid){
		$data = $this->where('user_id='.$uid)->find();
		$user_info = M('user_info')->where('user_id = '.$data['user_id'])->find();
		$other_info = $this->getUserInfoOther($data['user_id']);
		$data = array_merge($data,$other_info,(array)$user_info);
		return $data;
	}
	
	/**
	*	传入user_id 获取其他信息(避免代码重复)
	**/
	protected function getUserInfoOther($uid){
		$data = array();
		//获取此用户的粉丝
		$followers = D('Follow')->getFollowersByUserId($uid);				
		$data['followers'] = $followers;
		//获取此用户的关注
		$followings = D('Follow')->getFollowingsByUserId($uid);				
		$data['followings'] = $followings;
		//获取签到信息
		$sign = $this->is_sign($uid);
		$data['signs'] = $sign;
		//获取用户级别
		$aLevel = $this->getUserLevel($uid);
		$data['level'] = $aLevel;
		
		return $data;
	}
	
	/**
	*	根据用户积分获取用户等级
	**/
	protected function getUserLevel($uid){
		$aUserInfo = M('user_info')->field('sign_jifen jifen')->where('user_id='.$uid)->find();
		$nJifen = $aUserInfo['jifen'];
		$aLevel = $this->get_level($nJifen);
		return $aLevel;
	}
	
	/**
	*	根据积分定义用户级别
	*	@param1 用户积分
	*	@return number
	**/
	protected function get_level($nJifen){
		if($nJifen <= 0){
			$level = array('level'=>1,'nick'=>'天王地虎');
		}elseif($nJifen <= 20){
			$level = array('level'=>2,'nick'=>'小鸡炖菇');
		}elseif($nJifen <= 70){
			$level = array('level'=>3,'nick'=>'遁入糗门');
		}elseif($nJifen <= 100){
			$level = array('level'=>4,'nick'=>'探糗学问');
		}elseif($nJifen <= 200){
			$level = array('level'=>5,'nick'=>'有糗必应');
		}elseif($nJifen <= 500){
			$level = array('level'=>6,'nick'=>'糗意浓浓');
		}elseif($nJifen <= 1000){
			$level = array('level'=>7,'nick'=>'糗贤若渴');
		}elseif($nJifen <= 2000){
			$level = array('level'=>8,'nick'=>'切磋糗艺');
		}elseif($nJifen <= 3000){
			$level = array('level'=>9,'nick'=>'糗场贱将');
		}elseif($nJifen <= 6000){
			$level = array('level'=>10,'nick'=>'部落糗长');
		}elseif($nJifen <= 10000){
			$level = array('level'=>11,'nick'=>'梦寐以糗');
		}elseif($nJifen <= 18000){
			$level = array('level'=>12,'nick'=>'不糗甚解');
		}elseif($nJifen <= 30000){
			$level = array('level'=>13,'nick'=>'望穿糗岁');
		}elseif($nJifen <= 60000){
			$level = array('level'=>14,'nick'=>'糗门元老');
		}elseif($nJifen <= 100000){
			$level = array('level'=>15,'nick'=>'精益糗精');
		}elseif($nJifen <= 200000){
			$level = array('level'=>16,'nick'=>'糗友成蹊');
		}else{
			$level = array('level'=>17,'nick'=>'风靡全糗');
		}
		return $level;
	}
	
	
	/**
	*	md5 格式化密码串
	**/
	public function format_password($password){
		if($password === '' || $password === null){
			return false;
		}
		return md5($password);
	}
	
	
	/**
	*	判断是否可以签到
	*	@reutrn 0/1
	**/
	protected function is_sign($uid){
		$today = intval(date('Ymd',time()));
		$sign_res = M('user_info')->field('sign')->where('user_id = '.$uid)->find();
		$aSign = explode('|',$sign_res['sign']);
		$sign_time = empty($aSign[0]) ? 0 : $aSign[0];
		$sign_num = empty($aSign[1]) ? 0 : $aSign[1];
		$day = $today - intval($sign_time);		//当前日期减去上一次签到日期，如果大于 1 就视为签到中断，小于等于0 视为已签到
		$sign_int = explode(',',C('SIGN_INT'));		//获取用户每日签到奖励积分标准
		$return =array('is_sign'=>1,'count'=>$sign_num,'today'=>date('m 月 d 日',time()));
		if($day > 1){
			$return['sign_jifen'] = $sign_int[0];
			$return['count'] = 0;
		}else{
			if($day == 1){
				$return['count'] = $sign_num;
			}else{
				$return['is_sign'] = 0;
			}
			$jifen_count = count($sign_int);
			if($sign_num < ($jifen_count - 1)){	//判断是不是可签到的最后一天
				$return['sign_jifen'] = $sign_int[$sign_num];
			}else{
				$return['sign_jifen'] = $sign_int[$jifen_count-1];		//大于等于最后一天都按最后一天签到的标准给分
			}
		}
		return $return;
	}
	
	
	/**
	*	签到和返回今日能得到的积分
	**/
	public function sign_commit($uid){
		$today = intval(date('Ymd',time()));
		$sign_int = explode(',',C('SIGN_INT'));		//获取用户每日签到奖励积分标准
		$mUserInfo = M('user_info');
		
		$sign_res = M('user_info')->field('sign')->where('user_id = '.$uid)->find();
		$aSign = explode('|',$sign_res['sign']);
		$sign_time = $aSign[0];
		$sign_num = $aSign[1];
		$day = $today - intval($sign_time);		//当前日期减去上一次签到日期，如果大于 1 就视为签到中断，小于等于0 视为已签到
		if($day <= 0){
			return 0;		//已签到，不做任何处理
		}elseif($day > 1){		//中间中断过
			$data['sign'] = $today.'|'.(1);
			$setInc = $sign_int[0];
		}else{		//只剩下等于1的情况
			$jifen_count = count($sign_int);
			if($sign_num < ($jifen_count - 1)){	//判断是不是可签到的最后一天
				$setInc = $sign_int[$sign_num];
			}else{
				$setInc = $sign_int[$jifen_count-1];
			}
			$sign_num++;
			$data['sign'] = $today.'|'.$sign_num;
		}
		$mUserInfo->where('user_id='.$uid)->save($data);
		$mUserInfo->where('user_id='.$uid)->setInc('sign_jifen',$setInc);
		return $setInc;
	}
}