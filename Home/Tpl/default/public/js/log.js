$(function(){
	$("[name='email']").focus();
	
	//注册
	$("#register_form").submit(function(){
		$t = $(this);
		var email = $t.find("[name='email']").val();
		var user_name = $t.find("[name='user_name']").val();
		var password = $t.find("[name='password']").val();
		var repassword = $t.find("[name='repassword']").val();
		$t.find('.tips').text('');
		if(email == "" || email == null || /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email) == false){
			$t.find(".tips:eq(0)").html('邮箱格式不正确').animate({'opacity':'0.4'},2000,function(){$(this).css('opacity','1').html("此邮箱为您的唯一登陆账号");});
			$t.find("[name='email']").focus();
			return false;
		}
		if(user_name == "" || user_name == null || /\S+/g.test(user_name) == false){
			$t.find(".tips:eq(1)").html('用户名/昵称不能为空').animate({'opacity':'0.4'},2000,function(){$(this).css('opacity','1').html("输入一个你喜欢的别名！");});
			$t.find("[name='user_name']").focus();
			return false;
		}
		if(password == "" || password == null || password.length <= 4){
			$t.find(".tips:eq(2)").html('密码必须大于4位');
			$t.find("[name='password']").focus();
			return false;
		}
		if(repassword == "" || repassword == null || repassword != password){
			$t.find(".tips:eq(3)").html('两次密码不相同，请确认');
			$t.find("[name='repassword']").focus();
			return false;
		}
		
		var url = $t.prop('action');
		$t.find('.tips:eq(4)').html('waiting.....');
		$.post(url,{email:email,user_name:user_name,password:password,repassword:repassword},function(msg){
			if(msg.status == 1){
				$t.find('.tips:eq(4)').html(msg.info);
				location.href = $('.nav_ul .index a').prop('href');
			}else{
				$t.find('.tips:eq(4)').html(msg.info);
				return false;
			}
		});
		return false;
	});
	
	//登陆
	$("#login_form").submit(function(){
		$t = $(this);
		var email = $t.find("[name='email']").val();
		var password = $t.find("[name='password']").val();
		$t.find('.tips').text('');
		if(email == "" || email == null || /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email) == false){
			$t.find(".tips:eq(0)").html('邮箱格式不正确').animate({'opacity':'0.4'},2000,function(){$(this).css('opacity','1').html("此邮箱为您的唯一登陆账号");});
			$t.find("[name='email']").focus();
			return false;
		}
		if(password == "" || password == null || password.length <= 4){
			$t.find(".tips:eq(1)").html('密码必须大于4位');
			$t.find("[name='password']").focus();
			return false;
		}
		var url = $t.prop('action');
		$t.find('.tips:eq(2)').html('waiting.....');
		$.post(url,{email:email,password:password},function(msg){
			if(msg.status == 1){
				$t.find('.tips:eq(2)').html(msg.info);
				location.href = $('.nav_ul .index a').prop('href');
			}else{
				$t.find('.tips:eq(2)').html(msg.info);
				return false;
			}
		});
		return false;
	});
});








