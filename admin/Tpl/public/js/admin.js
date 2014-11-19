$(function(){
	//metro 块的阴影跟随块的background颜色
	$('a.metro').bind({
		'mouseenter':function(){
			var metro_bg = $(this).css('background-color');
			$(this).css({'box-shadow':'1px 1px 1px 1px '+metro_bg});
			$(this).children('span').stop().animate({'bottom':'15px'},200);
		},
		'mouseleave':function(){
			$(this).css('box-shadow','');
			$(this).children('span').stop().animate({'bottom':'10px'},200);
		}
	});
	
	
	//metro随即变色js
	var metro_length = $('a.metro').length;
	if(metro_length > 0){
		for(var i=0;i<metro_length;i++){
			rand = random(1,15);
			$('a.metro:eq('+i+')').addClass('metro_bg_'+rand);
		}
	}
	
	
});

/**
*	生成范围内随机数
**/
function random(min,max){
    return Math.floor(min+Math.random()*(max-min));
}

//全选反选
var full_check = function(cfg){
	var clicker = cfg.clicker;
	var selecter = cfg.selecter;
	$(clicker).click(function(){
		if($(this).attr('status') != '1'){
			$(selecter).prop('checked',true);
			$(this).attr('status','1');
		}else{
			$(selecter).prop('checked',false);
			$(this).attr('status','0');
		}
	});
};


//分页按钮的效果
var y_pager = function(cfg){
	var selecter = cfg.selecter;
	
	$(selecter).find('input[type=button]').click(function(){
		var page = $(selecter).find('input[type=text]:eq(0)').val();
		jump_url = $(selecter).find('a.active').attr('href');
		location.href = jump_url+'&page='+page;
	});
	
};

/**编辑用户信息**/
var edit_user = function(cfg){
	var attr = cfg.id_attr;
	var url = cfg.url;
	$('.edit_user').click(function(){
		var uid = $(this).attr(attr);
		$.post(url,{uid:uid},function(msg){
			if(msg.status == 1){
				y_dialog('编辑用户',msg.data);
			}
		});
	});
};

/**查看大图**/
var img_view = function(cfg){
	var selecter = cfg.selecter;
	$(selecter).click(function(){
		var img_src = $(this).prop('href');
		y_dialog('查看大图','<img src='+img_src+' />');
		return false;
	});
};


/**通用弹窗**/
var y_dialog = function(title,content){
	title = title ? title : '信息弹框';
	$.dialog({
		id : 'weiyi',
		title:title,
		content: content,
		padding:'20px',
		min:false,
		max:false,
		lock:true,
		fixed:true,
		cancel:true,
		cancelVal: '关闭'
	});
};



/**
*	根据文章ID，划过返回文章内容
**/
var hover_article = function(cfg){
	var selecter = cfg.selecter;
	var url = cfg.url;
	$(selecter).bind({
		'mouseenter':function(){
			var status = $(this).attr('status');
			var dom = this;
			if(status == '0'){
				var aid = $(this).attr('aid');
				$.post(url,{aid:aid},function(msg){
					if(msg.status == 1){
						$(dom).children('span.article').children('span').text(msg.data).parent().css({'opacity':'0.0','padding':'5px 0px'});
						$(dom).children('span.article').animate({'opacity':'0.8'},400);
					}
				});
				$(this).attr('status','1');
			}else{
				
			}
		},
		'mouseleave':function(){
			// $(this).children('span.article').slideUp(100);
		}
	});
};


/**
*	多项 checkbox 删除
**/
var double_del = function(cfg){
	var selecter = cfg.selecter;
	var clicker = cfg.clicker;
	var url = cfg.url;
	var model = cfg.model;
	var field = cfg.field;
	
	$(clicker).click(function(){
		var aIds = new Array();
		$(selecter).each(function(index){
			if($(this).prop('checked') == true){
				aIds[aIds.length] = $(this).val();
			}
		});
		var sIds = aIds.join(',');
		$.post(url,{ids:sIds,model:model,field:field},function(msg){
			
			location.reload();		//刷新页面
		});
	});
};


/**
*	管理员回复用户反馈
**/
var reply_fankui = function(cfg){
	var url = cfg.url;
	var selecter = cfg.selecter;
	$(selecter).click(function(){
		var fankui = prompt("给他/她回复","");
		if(fankui != null && fankui != ""){
			var uid = $(this).attr('uid');
			$.post(url,{fankui:fankui,uid:uid},function(msg){
				if(msg.status == 1){
					return true;
				}else{
					y_dialog('失败!',msg.info);
				}
			});
		}else{
			return false;
		}
	});
	
}










