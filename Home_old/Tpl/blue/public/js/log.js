$(function(){
	$("[name='email']").focus();
	
	//注册
	$("#register_form").submit(function(){
		var email = $("[name='email']").val();
		var user_name = $("[name='user_name']").val();
		var password = $("[name='password']").val();
		var repassword = $("[name='repassword']").val();
		if(email == "" || email == null){
			$(".tips:eq(0)").html('邮箱不能为空').fadeIn(1).fadeOut(3000,function(){$(this).html("此邮箱为您的唯一登陆账号").fadeIn(1);});
			$("[name='email']").focus();
			return false;
		}
		if(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email) == false){
			$(".tips:eq(0)").html('邮箱格式不正确').fadeIn(1).fadeOut(3000,function(){$(this).html("此邮箱为您的唯一登陆账号").fadeIn(1);});
			$("[name='email']").focus();
			return false;
		}
		if(user_name == "" || user_name == null){
			$(".tips:eq(1)").html('用户名/昵称不能为空').fadeIn(1).fadeOut(3000,function(){$(this).html("输入一个你喜欢的别名！").fadeIn(1);});
			$("[name='user_name']").focus();
			return false;
		}
		if(password == "" || password == null){
			$(".tips:eq(2)").html('密码不能为空').fadeIn(1).fadeOut(3000);
			$("[name='password']").focus();
			return false;
		}
		if(repassword == "" || repassword == null || repassword != password){
			$(".tips:eq(3)").html('两次密码不相同，请确认').fadeIn(1).fadeOut(3000);
			$("[name='repassword']").focus();
			return false;
		}
	});
	
	//登陆
	$("#login_form").submit(function(){
		var email = $("[name='email']").val();
		var password = $("[name='password']").val();
		if(email == "" || email == null){
			$(".tips:eq(0)").html('邮箱不能为空').fadeIn(1).fadeOut(3000,function(){$(this).html("此邮箱为您的唯一登陆账号").fadeIn(1);});
			$("[name='email']").focus();
			return false;
		}
		if(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email) == false){
			$(".tips:eq(0)").html('邮箱格式不正确').fadeIn(1).fadeOut(3000,function(){$(this).html("此邮箱为您的唯一登陆账号").fadeIn(1);});
			$("[name='email']").focus();
			return false;
		}
		if(password == "" || password == null){
			$(".tips:eq(1)").html('密码不能为空').fadeIn(1).fadeOut(3000);
			$("[name='password']").focus();
			return false;
		}
	});
});