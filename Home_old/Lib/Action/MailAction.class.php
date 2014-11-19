<?php
// 本类由系统自动生成，仅供测试用途
class MailAction extends HomeAction {
    public function index(){
		isset($_POST['address']) ? $address = $_POST['address'] : $address = '512511253@qq.com' ;
		$title = $_POST["title"];
		$message = $_POST['message'];
		isset($_POST['formname']) ? $formname = $_POST['formname'] : $formname = '糗星人' ;
		
		$su = $this->send_mail($address,$title,$message,$formname);		//支持HTML标签
		
		//SendMail('admin@waikucms.com','邮件标题','邮件正文','歪酷CMS管理员');
		//解释下参数: 参数1---目标邮箱, 参数2----邮件标题,参数三--邮件正文,参数四---发件人名称;
		//$mail->AddAttachment("images/phpmailer.gif");      //添加一个附件
    }
	public function to_user {
		isset($_POST['address']) ? $address = $_POST['address'] : exit ;
		$title = $_POST["title"];
		$message = $_POST['message'];
		isset($_POST['formname']) ? $formname = $_POST['formname'] : $formname = '糗星人' ;
		
		$su = $this->send_mail($address,$title,$message,$formname);		//支持HTML标签
	}
	
function send_mail($address,$title="",$message="",$formname="糗星人网站"){
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
}
?>