/**
*导航的划过JS
*/
$(document).ready(function(){
	
	//Fix Errors - http://www.learningjquery.com/2009/01/quick-tip-prevent-animation-queue-buildup/
	
	//When mouse rolls over
	$(".nav .down").mouseover(function(){
		var height = 0;
		if($(this).find('.subtext a').length > 0){
			$(this).find('a').each(function(){
				height += $(this).height();
			});
		}else{
			height = 150;
		}
		$(this).stop().animate({height:height+'px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
	//When mouse is removed
	$(".nav .down").mouseout(function(){
		$(this).stop().animate({height:'40px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
	
	
	//审帖右边按钮的效果
	$(".option a").hover(function(){
		$(this).addClass('on');
	},function(){
		$(this).removeClass('on');
	});
	
	//注册登录的弹窗
	$('.head_login').click(function(){
		if(action == 'user_login' || action == 'user_register'){
			location.href = $(this).attr(href);
		}
		pop_login({
			tab:'login'
		});
		return false;
	});
	$('.head_register').click(function(){
		if(action == 'user_login' || action == 'user_register'){
			location.href = $(this).attr(href);
		}
		pop_login({
			tab:'register'
		});
		return false;
	});
	
});

var my_alert = function(title,content){
	$.dialog({
		title:title,
		skin:'blue',
		content: content,
		padding:'20px',
		min:false,
		max:false,
		lock:true,
		fixed:true,
		cancel:true,
		cancelVal: '关闭'
	});
	return false;
}

/**
*	电梯
**/
var elevator = function(cfg){
	var scrolltime = cfg.speed;
	$(".gotop").click(function(){
		$('body').animate({scrollTop:0}, scrolltime);
		$('html').animate({scrollTop:0}, scrolltime);
	});
	$(".godown").click(function(){
		var offset = $(".foot").offset().top;
		$('body').animate({scrollTop:offset}, scrolltime);
		$('html').animate({scrollTop:offset}, scrolltime);
	});
};

/**
*	图片方法缩小
**/
var iviewer = function(cfg){
	var dom = cfg.dom;
	//图片放大缩小
	$(dom).live("mousedown",function(){
		var src = $(this).find("img:first").attr("src");
		var OriginImage=new Image();
		OriginImage.src = src;
		var width = OriginImage.width;
		var height = OriginImage.height;
		var dom_img = $(this).find("img:first");
		$(this).css({'overflow':'hidden','position':'relative','display':'block','width':width,'height':height});
		
		$(this).iviewer({
			src:src
		});
		$(this).find("img:last").hide(1).css('display','none');
	});
};

/****
*	 左右翻页的JS 
*/
var trun_page = function(configs){
	var page = configs.page;
	var page_num = configs.page_num;
	
	if(page == null || page <=0 || page == ""){
		page =1;
	}
	$(document).keyup(function(event){
			if($('.pop_big:visible').length > 0){
				return false
			}
            if(event.keyCode == 37){
				if(parseInt(page)>1){
					var $href = $('#kkpager a:first').attr("href");
					window.location.href = $href;
				}
            }else if(event.keyCode == 39){
				if(parseInt(page) < parseInt(page_num)){
					var $href = $('#kkpager a:last').attr("href");
					window.location.href = $href;
				}
            }
        });
        /* $('input,textarea').keyup(function(event){
			event.stopPropagation();
        }); */
};

/**
小纸条
*/
var message = function(configs){
	var post_url = configs.post_url;
	$(".former_user_name a").live('click',function(){
		var to_user_id = $(this).attr("u_id");
		var user_name = $(this).text();
		$.post(GROUP+'/user/get_log_status_ajax',{},function(msg){
			if(msg == false){
				my_alert('未登录','未登录，请先登录后发送站内小纸条');
				return false;
			}else{
				$.dialog({
					id:'weiyi',
					title:'给 《' + user_name + '》 发送小纸条',
					max:false,
					min:false,
					fixed: true,
					lock: true,
					padding:'10px 30px 10px 30px',
					content:'<textarea id="message" placeholder="秘密小纸条~" style="width:250px;height:60px;"></textarea>',
					ok: function(){
						var message = $("#message").val();
						if(message == null || message == "" || /\S+/g.test(message) == false){
							return false;
						}
						$.post(GROUP+post_url,{to_user_id:to_user_id,content:message},function(data){
							//alert(data);		//不返回消息，以后在用户中心查看
						});
						this.close();
						return false;
					},
					cancelVal: '取消',
					cancel: true
				});
			}
		});
	});
};

/**
*	文章的顶
**/
var up = function(configs){
	var url = configs.post_url;
	$(".other_article .up").live("click",function(){
		if($(this).hasClass('has')){
			return false;
		}
		dom = $(this);
		dom.css({'position':'relative'}).append('<img style="position:absolute;display:block;left:0px;top:0px;width:23px;" src="'+THEME_PATH+'/public/images/article_up.png"></img>') .children('img').animate({'top':'-30px'},300,function(){$(this).animate({'top':'-10px','opacity':'0','width':'10px'},150,function(){$(this).remove();$(this).parent().css('position','');});});
		var id = $(this).children('.up_span').attr('a_id');
		$.post(url,{article_id:id},function(msg){
			if(msg.status == 1){
				dom.children('.up_span').text(parseInt(dom.text())+1).closest('.L_bar').find('li').addClass('has');
			}else{
				my_alert('提示',msg.info);
			}
		});
	});
};
/**
*	文章的囧
**/
var down = function(configs){
	var url = configs.post_url;
	$(".other_article .down").live("click",function(){
		if($(this).hasClass('has')){
			return false;
		}
		dom = $(this);
		dom.css({'position':'relative'}).append('<img style="position:absolute;display:block;left:0px;top:0px;width:23px;" src="'+THEME_PATH+'/public/images/article_down.png"></img>') .children('img').animate({'top':'-30px'},300,function(){$(this).animate({'top':'-10px','opacity':'0','width':'10px'},150,function(){$(this).remove();$(this).parent().css('position','');});});
		var id = $(this).children('.down_span').attr('a_id');
		$.post(url,{article_id:id},function(msg){
			if(msg.status == 1){
				dom.children('.down_span').text(parseInt(dom.text())-1).closest('.L_bar').find('li').addClass('has');
			}else{
				my_alert('提示',msg.info);
			}
		});
	});
};

/**
*	分页的 init
**/
var page_init = function(configs){
	var totalPage = configs.page_num;
	var totalRecords = configs.article_num;
	var pageNo = configs.this_page;
	var action = configs.action;
	
	
	if(!pageNo){
		pageNo = 1;
	}
	//初始化分页控件
	//有些参数是可选的，比如lang，若不传有默认值
	kkpager.init({
		pno : pageNo,
		//总页码
		total : totalPage,
		//总数据条数
		totalRecords : totalRecords,
		//链接前部
		hrefFormer : 'pager_test',
		//链接尾部
		hrefLatter : '.html',
		getLink : function(n){
			return action + "/page/"+n;
		},
		lang : {
			prePageText : '上一页',
			nextPageText : '下一页',
			totalPageBeforeText : '共',
			totalPageAfterText : '页',
			totalRecordsAfterText : '篇糗事',
			gopageBeforeText : '转到',
			gopageButtonOkText : '确定',
			gopageAfterText : '页',
			buttonTipBeforeText : '第',
			buttonTipAfterText : '页'
		},
		isGoPage:true
	});
	//生成
	kkpager.generPageHtml();
};
	

/**
*	点击显示文章下的评论
**/
var get_comment = function(cfg){
	var url = cfg.post_url;
	var user_url = cfg.user_url;
	$(".L_bar .comment").live('click',function(){
		var comment_dom = $(this).parents('.L_bar').siblings('.comments');
		var text = $(this).find('span').attr("on");
		var dom = $(this);
		dom.find('span').attr("on",'1');
		if(text == '0'){
			if(comment_dom.length > 0){
				comment_dom.slideDown(300);
				return false;
			}
			var a_id = $(this).attr('a_id');
			dom.css('background','url('+PUBLIC+'/public/images/wait_15x15.gif) no-repeat scroll left transparent');
			$.post(url,{article_id:a_id},function(msg){
				var str="";
				if(msg.status == 1){
					var data = msg.data;
					for(var i=0;i<data.length;i++){
						str += "<div class=coms><ul><li>";
						//这里呀加一个判断是否是真用户，真用户要加链接的！
						if(0 < parseInt(data[i].user_id)){
							str += "<a class='a' target=_blank href="+user_url+"/user_id/"+data[i].user_id+"><img class=pic src="+data[i].pic+" /></a></li><li><a class='a' uid='"+data[i].user_id+"' target=_blank href="+user_url+"/user_id/"+data[i].user_id+">"+data[i].user_name+"</a></li>";
						}else{
							str += "<img class=pic src="+data[i].pic+" /></li><li>"+data[i].user_name+"</li>";
						}
						str += "<li class='comment_content'>"+data[i].content+"</li><span>"+(i+1)+"</span></ul></div>";
					}
				}
				str += '<div class="form"><input type="text" class="comment_input" /><input type="button" class="but" value="提交评论" /></div>';
				
				dom.parents('.L_bar').after("<div class='comments'>"+str+'</div>');
				dom.parents('.L_bar').siblings('.comments').slideDown(300);
				dom.parents('.L_bar').siblings('.comments').find('.comment_input').focus();
				dom.css('background','');
			});
		}else{
			$(this).parents('.L_bar').siblings('.comments').slideUp(200,function(){/* $(this).remove(); */});
			$(this).find('span').attr("on",'0');
		}
	});
};
/**
*	评论的提交
**/
var send_comment = function(cfg){
	var url = cfg.post_url;
	var user_url = cfg.user_url;
	$(".comments .but").live("click",function(){
		dom = $(this);
		var $comment = $(this).prev('.comment_input').val();
		var a_id = $(this).parents(".comments").prev().find('.comment').attr('a_id');
		if($comment == "" || $comment == null){
			return false;
		}
		$.post(url,{comment:$comment,article_id:a_id},function(msg){
			if(msg.status == 1){
				if(msg.data != null){
					var str = '<div class="coms"><ul><li>';
					var user_name = msg.data['user_name'];
					if(0 < parseInt( msg.data['user_id'])){
						str += "<a class='a' target=_blank href="+user_url+"><img class=pic src="+ msg.data['pic']+" /></a></li><li><a class='a' target=_blank href="+user_url+">"+user_name+"</a></li>";
					}else{
						str += "<img class=pic src="+ msg.data['pic']+" /></li><li>"+user_name+"</li>";
					}
					str += '<li class=comment_content>'+$comment+'</li><span>最新发表</span></ul></div>';
					dom.parents('.comments').children("div:last").before(str);
					dom.prev('.comment_input').val("");
				}
			}
		});
	});
};

/****
*	举报事件
*/
var report = function(cfg){
	var url = cfg.post_url;
	$('.L_option .report a').click(function(){
		var a_id = $(this).parents(".sf-menu").attr("a_id");
		var text = $(this).text();
		$.post(url,{article_id:a_id,text:text},function(data){
			if(data == 'success'){
				alert("举报成功!感谢您的参与");
			}else{
				if(data == "empty"){
					alert("参数错误，请刷新页面重试");
				}else{
					alert("服务器和程序员私奔了！稍候再试");
				}
			}
		});
	});
};



/**
*	移动版区事件
**/
var move_zone = function(cfg){
	var url = cfg.post_url;
	$('.L_option .move a').click(function(){
		var a_id = $(this).parents(".sf-menu").attr("a_id");
		var zone = $(this).attr('zone');
		$.post(url,{article_id:a_id,zone:zone},function(data){
			if(data == 'success'){
				alert("移动成功!感谢您的参与");
			}else{
				if(data == "empty"){
					alert("参数错误，请刷新页面重试");
				}else{
					alert("服务器和程序员私奔了！稍候再试");
				}
			}
		});
	});
};

/**
*	文章排序和选项
**/
var order_and_option = function(cfg){
	var by = cfg.by;
	var option = cfg.option;
	$(".order .by").removeClass("on");
	switch(by){
		case 'up': $(".by_up").addClass("on");break;
		default: $(".by_time").addClass('on');break;
	}
	switch(option){
		case 'hasname': $(".op_hasname").addClass("on");break;
		default: $(".op_hasname").removeClass("on");break;
	}
}; 


/**
*	文章的删除效果和ajax
**/
var del_article = function(cfg){
	var url = cfg.post_url;
	var dom = cfg.dom;
	$(dom).click(function() {
		var $this = this;
		$.dialog({
			id:'weiyi',
			title:'确定删除',
			max:false,
			min:false,
			fixed: true,
			lock: true,
			padding:'10px 30px 10px 30px',
			content:'您将删除此文章',
			ok: function(){
				var id = $($this).attr('a_id');
				$.post(url,{article_id:id},function(data){
					if(data.status == 1){
						$($this).closest(".text").remove();
					}else{
						alert(data.info+"，请刷新重试");
					}
				});
				this.close();
				return false;
			},
			cancelVal: '取消',
			cancel: true
		});
		//这里写完成的事件
		
		
	});
}

/**
*	审帖的右边点击事件
**/
var audit = function(cfg){
	var url = cfg.post_url;
	$.post(GROUP+url,{},function(msg){
		audit_dom(msg.data);
	});
	$(".option a").click(function(){
		var $this_bar = $(this).children('i').children('i');
		var $action = $(this).attr('action');
		var $a_id = $(this).attr('a_id');
		$this_bar.animate({'left':'0px'},1500);
		$.post(GROUP+url,{article_id:$a_id,action:$action},function(msg){
			audit_dom(msg.data);
			$this_bar.stop().animate({'left':'-114px'},100);
		});
		return false;
	});
};

//传入msg.data做dom操作
function audit_dom(data){
	if(data != null)
	{
		$(".content .text").text(data.content);
		if(data.image != null && data.image != ""){
			var str = "<div>";
			for(var i=0;i<data.image.length;i++){
				str += '<img width="400" src="'+data.image[i].image_link+'" /><br />';
			}
			str += '</div>';
			$(".content .text").append(str);
		}
		$(".option a").attr("a_id",data.id);
	}else{
		$('.auditer').html('<div class="null">悲剧，被审核完了</div>');
	}
}

/**
*	用户修改密码的信息验证
**/
var repwd_form = function(cfg){
	$("form").submit(function(){
		var old_pwd = $("[name='old_pwd']").val();
		if(old_pwd == null || old_pwd == ""){
			$(".old_span").text("请输入原密码").fadeIn(1).fadeOut(2000,function(){
				$(this).text("");
			});
			return false;
		}
		var new_pwd = $("[name='new_pwd']").val();
		if(new_pwd == null || new_pwd == ""){
			$(".new_span").text("请输入新密码").fadeIn(1).fadeOut(2000,function(){
				$(this).text("");
			});
			return false;
		}
		var new_pwd2 = $("[name='new_pwd2']").val();
		if(new_pwd2 == null || new_pwd2 == ""){
			$(".new_span2").text("请确认新密码").fadeIn(1).fadeOut(2000,function(){
				$(this).text("");
			});
			return false;
		}else{
			if(new_pwd2 != new_pwd){
				$(".new_span2").text("两次密码不一致").fadeIn(1).fadeOut(2000,function(){
					$(this).text("");
				});
				return false;
			}else{
				return true;
			}
		}
	});
};

/**
*	填补页面下方的空白，避免大分辨率电脑浏览下 footer 文件不在最底部的问题
**/
var fix_footer = function(cfg){
	var c = cfg.center_dom;
	var client_h = $(window).height();
	var head_h = $(".head").height();
	var foot_h = $(".foot").height();
	var offset_foot_h = $(".foot").offset().top;
	var bottom_h = client_h - (offset_foot_h + foot_h);
	if(bottom_h > 0){
		$(c).height(client_h - (head_h + foot_h));
	}
};

/**
*	划过显示用户信息
**/
var user_info = function(cfg){
	var dom = cfg.dom;
	var public_dir = cfg.public_dir;
	var url = cfg.post_url;
	//根据 dom 的 u_id 属性取到用户id
	$(dom).bind({
		'mouseenter':function(){
			$(this).css({'position':'relative'});
			var u_id = $(this).attr("u_id");
			var width = $(this).width();
			var height = $(this).height();
			var doms = this;
			$.post(url,{user_id:u_id},function(msg){
				if(msg.status == 1){
					var dialog_dom = "<div class='dialog_user_info' style='left:"+width+"px;height:"+top+"px;'>"+
					'<div class="user_bg" style="background:url('+msg.data.user_bg+') repeat scroll 0 0 transparent;"></div><div class="user_info"><img class="pic" src="'+msg.data.pic+'" /><span class="user_name">'+msg.data.user_name+'</span><ol><li class="email">邮箱：'+msg.data.email+'</li><li class="reg_time">注册时间：'+msg.data.reg_time+'</li><li class="last_login_time">最后登陆时间：'+msg.data.last_log_time+'</li></ol></div>'
					+"</div>";
					$(doms).append(dialog_dom);
					$(doms).children(".dialog_user_info").fadeIn(500);
				}
			});
			
		},
		'mouseleave':function(){
			$(dom).children(".dialog_user_info").remove();
		}
	});
};


/**
*	瀑布流加载下一页内容
**/
var next_page = function(cfg){
	var url = cfg.post_url;
	var page = 1;	//定义页数，来判断当前数据量，初始第1页为程序默认数据量，
	var scroll_num = 0;		//初始化滚动事件为0.
	$(window).bind('scroll resize',function(){
		var document_h = $(document).height();
		var scroll_top = $(document).scrollTop();

		var windowHeight= $(window).height();
		var h = document_h-(scroll_top + windowHeight);
		//判断到达底部并且滚动的请求数为1(控制一次请求)
		if(h <= 250){
		//这里滚动次数为自增来判断是否第一次在此范围内滚动
		scroll_num++;
		if(scroll_num == 1){
		//显示一个等待动画
			$(".left .load").fadeIn(500);
				page++;
				$.post(url,{page:page},function(msg){
					$(".left .load").css({'display':'none'});	//先把 gif 去掉
					if(msg.status == 1){
						var data = msg.data;
						var content = "";
						for(i in data){
							
							content += '<div class="L_content">';
							
							/* content + ='<div class="L_option"><ul class="sf-menu" a_id = "'+data[i].article_id+'"><li><a href="javascript:;">举报</a><ul class="report"><li><a href="javascript:;">反动</a></li><li><a href="javascript:;">黄色暴力</a></li><li><a href="javascript:;">与网站无关</a></li></ul></li><li><a href="javascript:;">移动到区</a>	<ul class="move"><li><a href="javascript:;" zone="1">{$Think.config.z1.word}</a></li><li><a href="javascript:;" zone="2">{$Think.config.z2.word}</a></li><li><a href="javascript:;" zone="3">{$Think.config.z3.word}</a></li></ul></li></ul></div>'; */

							if(data[i].pic != null && data[i].pic != ''){
								content += '<div class="L_user"><span class="pic"><a href="javascript:;" title="关注Ta"><img class="img" src="'+data[i].pic+'" /><span class="guanzhu"></span></a></span><span class="former_user_name"><a u_id="'+data[i].former_user_id+'" title="发送小纸条" href="javascript:;">'+data[i].former_user_name+'</a></span></div>';
							}
							content += '<div class="L_text">'+data[i].content+'</div>';
							if(data[i].image != null){
								content += '<div class="L_image">';
								if(is_string(data[i].image)){
									content += '<a title="糗星人" alt="糗星人，图片正在加载中">';
									content += '<img src="'+data[i].image+'" /></a>';
								}else{
									for(var imgi=0;imgi<data[i].image.length;imgi++){
										content += '<a title="糗星人" alt="糗星人，图片正在加载中">';
										content += '<img src="'+data[i].image[imgi].image_link+'" /></a>';
										
									}
								}
								content += '</div>';
							}
							content += '<div class="L_bar"><ul><li class="up"><span class="up_span" a_id="'+data[i].id+'">'+data[i].up+'</span></li><li class="down"><span class="down_span" a_id="'+data[i].id+'">'+data[i].down+'</span></li><li class="space">'+new Date((data[i].add_time)*1000).Format("yyyy-MM-dd hh:mm:ss")+'</li><li class="comment" a_id="'+data[i].id+'"><span on="0">评论 '+data[i].comment_count+'</span></li></ul></div></div>';
						}
						$(".left .L_content:last").after(content);
						
					//如果如果成功就初始化滚动次数，以便下次请求，否则失败表示服务器问题或有bug不再请求ajax	
					scroll_num = 0;
					}else{
						$(".left .load").html("<span>没有更多了</span>").fadeIn(500);
					}
				});
			}
		}
	});
};

/**
*	瀑布流加载下一页内容  201408 新
**/
var next_page_201408 = function(cfg){
	var url = cfg.post_url;
	var page = 1;	//定义页数，来判断当前数据量，初始第1页为程序默认数据量，
	var scroll_num = 0;		//初始化滚动事件为0.
	$(window).bind('scroll resize',function(){
		var document_h = $(document).height();
		var scroll_top = $(document).scrollTop();

		var windowHeight= $(window).height();
		var h = document_h-(scroll_top + windowHeight);
		//判断到达底部并且滚动的请求数为1(控制一次请求)
		if(h <= 450){
		//这里滚动次数为自增来判断是否第一次在此范围内滚动
		scroll_num++;
		if(scroll_num == 1){
		//显示一个等待动画
			$(".left .load").fadeIn(500,function(){
				$(this).find('.loadbar').css('width','0%').stop().animate({'width':'100%'},15000);
			});
				page++;
				$.post(url,{page:page},function(msg){
					$(".left .load").css({'display':'none'});	//先把 gif 去掉
					if(msg.status == 1){
						var data = msg.data;
						var content = "";
						for(i in data){
							content += '<div class="L_content other_article"><div class="user_info"><span class="user_pic"><img class="pic_img" src="'+data[i].pic+'" />';
							if(data[i].former_user_name != false ){
								content += '<span class="guanzhu" title="关注 Ta，成为 Ta 的粉丝！"></span>';
							}
							content += '</span><span class="former_user_name">';
							if(data[i].former_user_name != false ){
								content += '<a u_id="'+data[i].former_user_id+'" title="发送小纸条" href="javascript:;">'+data[i].former_user_name+'</a></span>';
							}else{
								content += '匿名用户发表';
							}
							content += '</div><div class="article_info"><div class="text"><span class="san_jiao_top"></span><span class="san_jiao">∠</span><span class="san_jiao_bottom"></span><div class="fun_title">'+data[i].title+'</div><div class="fun_text">'+data[i].content+'</div>';
							
							if(data[i].image != null){
								content += '<div class="L_image">';
								if(is_string(data[i].image)){
									content += '<a title="糗星人" alt="糗星人，图片正在加载中">';
									content += '<img src="'+data[i].image+'" /></a>';
								}else{
									for(var imgi=0;imgi<data[i].image.length;imgi++){
										content += '<a title="糗星人" alt="糗星人，图片正在加载中">';
										content += '<img src="'+data[i].image[imgi].image_link+'" /></a>';
										
									}
								}
								content += '</div>';
							}
							content += '</div><div class="L_bar"><ul><li class="up"><span class="up_span" a_id="'+data[i].id+'">'+data[i].up+'</span></li><li class="down"><span class="down_span" a_id="'+data[i].id+'">'+data[i].down+'</span></li><li class="space">'+new Date((data[i].add_time)*1000).Format("yyyy-MM-dd hh:mm:ss")+'</li><li class="comment" a_id="'+data[i].id+'"><span on="0">评论 '+data[i].comment_count+'</span></li></ul></div></div></div>';


						}
						
						
						$(".left .L_content:last").after(content);
						
					//如果如果成功就初始化滚动次数，以便下次请求，否则失败表示服务器问题或有bug不再请求ajax	
					scroll_num = 0;
					}else{
						$(".left .load").html("<span>没有更多了</span>").fadeIn(500);
					}
				});
			}
		}
	});
};




function is_string(str){ 
	return (typeof str=='string')&&str.constructor==String; 
} 


/**
*	关注用户
**/
var follow = function(cfg){
	var dom = cfg.dom;
	var url = cfg.post_url;
	$(dom).live('click',function(){
		var uid = $(this).closest(".L_user").find("a[u_id]:first").attr('u_id');
		$.post(GROUP+url,{uid:uid},function(msg){
			if(msg.status == -1){
				my_alert('请登录','<h2>请先<a target="_blank" class="dialog_login" href="'+ (GROUP+'/user/login') +'">登录</a>.<br />此功能为会员用户功能</h2>');
			}else {
				my_alert('提示','<h2>'+msg.info+'</h2>');
			}
		});
	});
	
};







/**
*	循环获取用户未读消息
**/
var new_message = function(cfg){
	var url = cfg.post_url;
	var title = $("title").text();
	var post_message = function(){
		$.post(GROUP+url,{action:action},function(msg){
			if(msg.status == 1 && msg.data > 0){
				$(".message_num").text(msg.data).css({"color":"#00D900","font-weight":"bold"});
				$("title").text("【有"+msg.data+"条新信息】"+title);
			}
		});
	};
	post_message();
	var interval = setInterval(post_message,600000);
};

/**点击就地ajax编辑**/
var click_edit = function(cfg){
	var selecter = cfg.selecter;
	var url = cfg.post_url;
	$(selecter).find('span').live('click',function(){
		var old_val = $(this).text();
		$(this).parent().html('<textarea style="width:100%;height:80px;">'+old_val+'</textarea>').children().focus();
	});
	$(selecter).find('textarea').live('blur',function(){
		var new_val = $(this).val();
		var dom = this;
		$(dom).parent().css({'opacity':'0.4'});
		$.get(GROUP+url,{content:new_val},function(msg){
			if(msg.status == 1){
				$(dom).parent().html('<span>'+new_val+'</span>').css({'opacity':'1'});
			}else{
				$(dom).parent().html('<span>编辑失败</span>').css({'opacity':'1'});
			}
		});
		
	});
};

/**签到**/
var sign = function(cfg){
	var selecter = cfg.selecter;
	$(selecter).click(function(){
		$.post(GROUP+'/usercenter/sign',{},function(msg){
			if(msg.status == 1){
				if(msg.data != 0){
					$('.sign > a').addClass('disabled').html('已签到'+msg.data+'分');
					var count = $('.sign > .sign_info b.count').text();
					count = parseInt(count);
					$('.sign > .sign_info b.count').text(++count);
					
					var jifen = $('.jifen_num').text();
					jifen = parseInt(jifen);
					$('.jifen_num').text(jifen+parseInt(msg.data));
				}else{
					my_alert('提示','已经签到过了，明天再来吧！');
				}
			}
		});
	});
};

/**右边的反馈**/
var proposal = function(cfg){
	var selecter = cfg.selecter;
	var post_url = cfg.post_url;
	var parent = $(selecter).closest('li');
	$(selecter).click(function(){
		if(parent.children('textarea:hidden').length > 0){
			parent.children('textarea').slideDown(300).focus();
		}else{
			parent.children('textarea').focus();
		}
	});
	
	parent.children('textarea').blur(function(){
		var content = $(this).val();
		var error = '';
		if(content == null || content == '' || /\S+/g.test(content) == false){
			error = '内容为空，未发送';
		}else{
			$.post(GROUP+post_url,{content:content},function(msg){
				if(msg.status == 1){
					error = '反馈已接收,感谢';
				}else{
					error = '反馈未接收到';
				}
				parent.find('.proposal').children('span').text(error).animate({'opacity':'1.0'},1000,function(){$(this).text('点击反馈');});
				parent.children('textarea').slideUp(100);
			});
		}
		parent.find('.proposal').children('span').text(error).animate({'opacity':'1.0'},1000,function(){$(this).text('点击反馈');});
		parent.children('textarea').slideUp(100);
	});
};

/**
*	ajax 弹窗登陆
**/
var pop_login = function(cfg){
	var tab = cfg.tab;
	$('.pop_big').fadeIn(0);
	$('.pop_bg').click(function(){
		$('.pop_big').fadeOut(100);
	});
	if(tab == 'login'){
		tab = 0;
		//获取用户邮箱对应头像，类似QQ的输入qq显示头像功能
		$('.pop_login .parent input[name=email]').blur(function(){
			var email = $(this).val();
			var $t = $(this);
			$.post(GROUP+'/user/get_pic',{field:'email',value:email},function(msg){
				if(msg.status == 1){
					$t.parent().siblings('.back_image').html('<img src="'+msg.data.pic+'" width="40" height="40" />');
				}else{
					//$t.closest('.login .log_in .tips:eq(0)').text(msg.info);
				}
			});
		});
	}else if(tab == 'register'){
		tab = 1;
	}
	
	$('.pop_login input').focus(function(){
		$(this).closest('ul').css({'border-color':'#C4BBAF'});
	});
	$('.pop_login input').blur(function(){
		$(this).closest('ul').css({'border-color':'#DBD9D6'});
	});
	$('.pop_login .tab > ul > li').removeClass('active');
	$('.pop_login .tab > ul > li:eq('+tab+')').addClass('active');
	$('.pop_login .tab_input > div[action]').css('display','none');
	$('.pop_login .tab_input > div[action]:eq('+tab+')').css('display','block');
	var dom = '.pop_login > .parent';
	$(dom).css({'margin-top':0,"margin-left":0,'position':'fixed'});
	var height = $(dom).height();
	var width = $(dom).width();
	$(dom).css({'margin-left':'-'+width/2+'px','margin-top':'-'+height/2+'px'});
	
	$('.pop_login .tab > ul > li').click(function(){
		$(this).siblings('li').removeClass('active');
		$(this).addClass('active');
		var index = $(this).index();
		var animate_width = $('.tab_input > div[action]:eq('+index+')').width();
		$('.tab_input > div[action]:not(:eq('+index+'))').css('display','none');
		$('.tab_input > div[action]:eq('+index+')').css('display','block');
	});
	
	
	//最后一步定位焦点
	$('.pop_login input[name=email]').focus();
	
};

