<?php

function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'' : $slice;
}
//计算时间
function get_nowtime($time){
    if($rtime = (time()-$time)/3600/24/365>1){
        $rtime = (time()-$time)/3600/24/365;
        return floor($rtime)."年前";
    }elseif($rtime = (time()-$time)/3600/24/30>1){
        $rtime = (time()-$time)/3600/24/30;
        return floor($rtime)."月前";
    }elseif($rtime = (time()-$time)/3600/24>1){
        $rtime = (time()-$time)/3600/24;
        return floor($rtime)."天前";
    }elseif($rtime = (time()-$time)/3600>1){
        $rtime = (time()-$time)/3600;
        return floor($rtime)."小时前";
    }elseif((time()-$time)/60>1){
        $rtime = (time()-$time)/60;
        return floor($rtime)."分钟前";
    }elseif((time()-$time)<60){
        return time()-$time."秒前";
    }
}

/**
*	@param1 发送地址
*	@param2	显示标题
*	@param2	内容
*	@param2	来自谁
**/
function send_mail($address,$title,$message,$formname='糗星人'){
	vendor('PHPMailer.phpmailer');
	$mail=new PHPMailer();
	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();
 
	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
 
	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);
 
	// 设置邮件正文
	$mail->Body=$message;
	
	// 设置邮件头的From字段。
	$mail->From=C('MAIL_ADDRESS');
 
	// 设置发件人名字
	$mail->FromName=$formname;
 
	// 设置邮件标题
	$mail->Subject=$title;
 
	// 设置SMTP服务器。
	$mail->Host=C('MAIL_SMTP');
 
	// 设置为"需要验证"
	$mail->SMTPAuth=true;
 
	// 设置用户名和密码。
	$mail->Username=C('MAIL_LOGINNAME');
	$mail->Password=C('MAIL_PASSWORD');
 
	// 发送邮件。
	$mail->IsHTML(true);
	return($mail->Send());
}



/**
 * 把二维数组按某值排序
 */
function array_sort($arr,$keys,$type='desc'){
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array;
}

/**
*	unix 时间戳格式化
**/
function format_time($unix_time){
	if(empty($unix_time)){
		return '...';
	}
	return date('Y-m-d H:i:s',$unix_time);
}

/**
*	获取用户ID
**/
function user_id(){
	$user_cookie = cookie('user_cookie');
	if(empty($user_cookie)){
		return 0;
	}
	return $user_cookie['user_id'];
}


/*
* 预处理css,变量等操作，写入缓存文件中调用
* @param1	array	原css链接
* @return	array	处理后的文本
*/
function replace_css($content){
	preg_match_all('/href=.*?\.css/',$content,$match);
	foreach($match[0] as $k => $v){
		$href = substr($v,6);
		$url = 'http://'.$_SERVER['HTTP_HOST'].$href;
		$css_text = file_get_contents($url);
		if(empty($css_text)) continue;
		preg_match('/\$[\w\d]{1,40}\s{0,4}=.*/',$css_text,$match);
		preg_match('/\$[\w\d]{1,40}/',$match[0],$match_var);
		$var = $match_var[0];
		
		preg_match('/[\'\"].*[\'\"]/',$match[0],$match_val);
		$val = trim_quotes($match_val[0]);	//匹配等号后的对应值
		$css_text = preg_replace('/\$[\w\d]{1,40}\s{0,4}=.*/','',$css_text);
		$css_text = str_replace($var,$val,$css_text);
		
		//取当前文件名
		$name = $href.'_temp.css';
		file_write($css_text,substr($name,2));
		
		$content = str_replace($href,$name,$content);
	}
	return $content;
}

//去掉两边的一个字符
function trim_quotes($text){
	return substr($text,1,-1);
}

// thinkphp在当前项目下写入文件
function file_write($text,$path){
	if ($handle = fopen($path, "w+")) {
		if (!fwrite($handle, $text) == FALSE) {
			fclose($handle);
		}
	}
}


//curl 返回页面的代码 $html
function curl($url){
	//初始化
	$curl = curl_init();
	//$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
	$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
	// $client_ip = '117.59.224.61:80';
	//设置参数
	$option = array(
		CURLOPT_URL				=> $url,
		CURLOPT_HEADER			=> 0,
		CURLOPT_FAILONERROR 	=> 1,		//遇到错误是否继续
		CURLOPT_RETURNTRANSFER	=> 1,		//返回还是输出请求的数据  -- 可以不用设置，本例为调试，所以开启
		CURLOPT_NOPROGRESS		=> 0,
		CURLOPT_TIMEOUT			=> 20,		//设置超时时间，表示最长运行时间
		CURLOPT_CONNECTTIMEOUT	=> 20,
		CURLOPT_FOLLOWLOCATION	=> 1,
		CURLOPT_HTTPGET			=> 1,
		CURLOPT_AUTOREFERER		=> 1,
		CURLOPT_PROXY			=> "http://".$ip,	//ip欺骗，避免被封IP
		CURLOPT_USERAGENT		=>	"Mozilla/5.0 (Windows NT 6.3; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0",
		//CURLOPT_HTTPHEADER		=> array('CLIENT-IP:'.$ip, 'X-FORWARDED-FOR:'.$ip),
		CURLOPT_HTTPHEADER		=> array('CLIENT-IP:'.$client_ip.', X-FORWARDED-FOR:'.$client_ip),//此处可以改为任意假IP
		CURLOPT_REFERER			=> "http://www.baidu.com/",
	);
	
	curl_setopt_array($curl,$option);
	//运行事务
	$html = curl_exec($curl);
	if(curl_error($curl) != ''){	//如果错误
		echo 'Curl error: ' . curl_error($curl).'<br />';
	}
	//关闭curl
	curl_close($curl);
	//返回结果
	return $html;
}



//登陆或者发布产品的时候取验证码链接，得到验证码图片
function get_image($url,$filename){
	global $client_ip;
	global $ip;
	//获取空间头像图片
	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$imageData = curl_exec($curl);
	curl_close($curl);
	if(file_exists($filename)){
		unlink($filename);
	}
	$tp = @fopen($filename, 'a');
	fwrite($tp, $imageData);
	fclose($tp);
}

	//正则出此页的内容条数。
	function preg_list($html){
		
		$pattern = '/<div\sclass=\"article\sblock\suntagged\smb15\".*?<div\sclass=\"up-arrow\"><\/div>/is';
		preg_match_all($pattern,$html,$match);
		return $match;
	}
	function preg_id($matchs){
		//id='qiushi_tag_61967636'
		$pattern = '/qiushi_tag_\d{8,15}/';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$pattern = '/\d{8,15}/';			//再正则出纯数字
			preg_match($pattern,$match[0],$match_id);
			$id[$key] = $match_id[0];
		}
		return $id;
	}
	function preg_author_name($matchs){
		//<a href="/users/14495086"><img src="http://pic.qiushibaike.com/system/avtnew/1449/14495086/thumb/20140313154129.jpg" alt="干掉小伙伴、" /></a>
		$pattern = '/<a\shref=\"\/users\/\d{1,15}\">.*?\s<\/a>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$pattern2 = '/alt=\".*?\"/is';
			preg_match($pattern2,$match[0],$match2);
			// $author[$key] = trim(strip_tags($match[0]));
			$author[$key] = substr(trim($match2[0]),5,-1);
		}
		return $author;
	}
	function preg_author_id($matchs){
		//<div class="author"><img src="http://static.qiushibaike.com/images/thumb/missing.png" alt="太阳出来我晒几把" /><a href="/users/14092261" >太阳出来我晒几把 </a></div>
		$pattern = '/\/users\/\d{1,15}/';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$author[$key] = substr($match[0],7);
		}
		return $author;
	}
	function preg_author_pic($matchs){
		//<a href="/users/14495086"><img src="http://pic.qiushibaike.com/system/avtnew/1449/14495086/thumb/20140313154129.jpg" alt="干掉小伙伴、" /></a>
		$pattern = '/<a\shref=\"\/users\/\d{1,15}\">.*?<\/a>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$pattern2 = '/\"http.*?\"/is';
			preg_match($pattern2,$match[0],$match2);
			$author[$key] = str_replace('"','',$match2[0]);
			if($author[$key] == "") $author[$key] = null;
		}
		return $author;
	}
	//正则出内容
	function preg_content($matchs){
	//传进来的是数组，为一页的19列
		$pattern = '/<div\sclass=\"content\".*?<\/div>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$content[$key] = trim(strip_tags($match[0]));
		}
		return $content;
	}
	function preg_thumb($matchs){
		$pattern = '/<div\sclass=\"thumb\".*?<\/div>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$thumb[$key] = $match[0];
		}
		return $thumb;
	}
	function preg_up($matchs){
		//<li id="vote-up-71349235" class="up">
		//<span class="number hidden">29</span>
		// $pattern = '/<a\shref.{30,35}id=\"up.*?<\/a>/is';
		$pattern = '/class=\"up\">.*?<\/li>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$pattern2 = '/<span\sclass=\"number\shidden\">\d*?<\/span>/is';
			preg_match($pattern2,$match[0],$match2);
			$up[$key] = trim(strip_tags($match2[0]));
		}
		return $up;
	}
	function preg_down($matchs){
		//<a href="javascript:vote2(62071295,-1)" id="dn-62071295" title="-16个拍">-16</a>
		$pattern = '/class=\"down\">.*?<\/li>/is';
		foreach($matchs as $key => $value){
			preg_match($pattern,$value,$match);
			$pattern2 = '/<span\sclass=\"number\shidden\">.\d*?<\/span>/is';
			preg_match($pattern2,$match[0],$match2);
			$up[$key] = trim(strip_tags($match2[0]));
		}
		return $up;
	}

?>