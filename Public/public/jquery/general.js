$(document).ready(function(e) {
jl();
start();
setInterval(function(){jk()},100);
});
function jk()
{
	os();
}
function yh()
{
    $("#st").toggle(250);
}
function resize()
{
	jl();
	$("g").remove();
	start();
}
function start()
{
	if(ts=="random")
	{
		_rand();
	}
	for(i=0;i<b;i++)
	{
		$("#dv").html($("#dv").html()+"<g></g>");
	}
	for(i=0;i<b;i++)
	{
		a=$( $("g")[i] ).css("top",String(innerHeight)+"px");	
	}
	gg=setInterval(function(){u()},100);
}
function u()
{
	var hp=0;
	var dc=0;
	for(i=0;i<b;i++)
	{
		a=$( $("g")[i] );
		if(parseFloat(a.css("top"))>=(innerHeight)&&Math.floor(Date.now()*(Math.random()*10))%4==0)
		{
			s(a);
		}	
		if(parseFloat(a.css("font-size"))>hp&&(parseFloat(a.css("top"))>=0&&parseFloat(a.css("top"))<innerHeight))
		{
			dc=i;
			hp=parseFloat(a.css("font-size"));
		}
	}
	if(hb)
{
	rb=$( $("g")[dc] );
	rb.css("filter","blur(0px)");
	rb.css("-webkit-filter","blur(0px)");
	rb.css("font-size",String(parseFloat(a.css("font-size"))*1.5));
}
}
function s(k)
{
	d=sp+(Date.now()*(Math.random()*10))%innerWidth;
	k.css("top",String((((Date.now()*(Math.random()*10))%200)*-1)-200)+"px");
	k.css("left",String(((Math.floor(Date.now()/Math.random()*10))%(innerWidth+500))-500)+"px");
	
	if(ts=="binary")
	a.html(_bin());
	else
	if (ts=="hex-upper case")
	k.html(_hex("c"))
	else
	if(ts=="hex-lower case")
	k.html(_hex("lc"));
	else
	if(ts=="eng-lower case")
	a.html(_eng("lc"));
	else
	if(ts=="eng-upper case")
	a.html(_eng("c"));
	else
	if(ts=="decimal")
	a.html(_decimal());
	else
	if(ts=="mix")
	a.html(_mix());
	else
	if(ts=="chinese")
	a.html(_chinese());
	op=innerHeight+(Date.now()*Date.now())%innerWidth;
	tt=(op-parseFloat(k.css("top"))*2);
	k.css("font-size"," "+String((tt/5)*mfs)+"%");
	if(hb)
	{
	hj=parseFloat(k.css("font-size"))/40;
	oi=hh-(hj-hh);
	k.css("-webkit-filter","blur("+String(oi)+"px)");
	k.css("filter","blur("+String(oi)+"px)");
k.css("Z-index",String(Math.floor(oi)));
	}
	else
	{
	k.css("-webkit-filter","");
	k.css("filter","");
	k.css("text-shadow","");
	}
	k.animate({top:String(op)+"px"},{duration:d,easing:"linear",queue:false});
}
var tg;
function jl()
{
	if(innerHeight>innerWidth&&!tg)
	{
		b/=1.5;
		tg=true;
	}
	else
	{
		if(tg)
		b*=1.5;
		tg=false;
	}
}
function _bin()
{
	return String(Math.floor(Date.now()*(Math.random()*10))%2);
}
function _hex(rg)
{
	var gh;
	var uy=Math.floor(Date.now()*(Math.random()*10))%16+1;
	if(uy<11)
	{
		gh=String(uy);
	}
	if(rg=="c")
	switch (uy)
	{
		case 11:
		gh="A";
		break;
		case 12: 
		gh="B";
		break;
		case 13:
		gh="C";
		break;
		case 14:
		gh="D";
		break;
		case 15:
		gh="E";
		break;
		case 16:
		gh="F";
		break;
	}
	else
	if(rg=="lc")
	switch (uy)
	{
		case 11:
		gh="a";
		break;
		case 12: 
		gh="b";
		break;
		case 13:
		gh="c";
		break;
		case 14:
		gh="d";
		break;
		case 15:
		gh="e";
		break;
		case 16:
		gh="f";
		break;
	}
	return gh;
}

function _eng(ok)
{
	if(ok=="c")
	tb=Math.floor(Date.now()*(Math.random()*10))%25+65;
	else
	if(ok=="lc")
	tb=Math.floor(Date.now()*(Math.random()*10))%25+97;
	return "&#"+String(tb)+";"
}
function _mix()
{
	var un;
	if(Date.now()%50==2)
	un=_chinese();
	else
	un=String.fromCharCode(Date.now()%870);
	return un;
}
function _decimal()
{
	var un=String.fromCharCode(Math.floor(Date.now()*(Math.random()*10))%870);
	return Date.now()%10;
}
function _chinese()
{
	var fr,to;
	switch(Date.now()%4)
	{
		case 0:
		fr=0x4E00;to=0x62FF;
		break;
		case 1:
		fr=0x6300;to=0x77FF;
		break;
		case 2:
		fr=0x7800;to=0x8CFF;
		break;
		case 3:
		fr=0x8D00;to=0x9FCC;
		break;
	}
	rv=String.fromCharCode(Math.floor(fr + Math.random() * (to-fr+1)));
	return rv;
}
function _rand()
{
	switch(Date.now()%8)
	{
		case 0:
		ts="binary";
		break;
		case 1:
		ts="hex-upper case";
		break;
		case 2:
		ts="hex-lower case";
		break;
		case 3:
		ts="eng-upper case";
		break;
		case 4:
		ts="eng-lower case";
		break;
		case 5:
		ts="decimal";
		break;
		case 6:
		ts="chinese";
		break;
		case 7:
		ts="mix";
		break;
	}
}
function os()
{
	//sp=parseFloat($("#spt").val());
	ts=$("#ics").val();
	$("g").css("color",$("#tct").val());
	$("#dv").css("background-color",$("#bct").val());
	$("g").css("font-family",$("#ft").val());
	hh=parseFloat($("#bt").val());
	mfs=parseFloat($("#mfss").val());
	if(ts=="random")
	{
		_rand();
	}
	if($("#awb").is(":checked"))
	{
	$("#wb").css("display","");
	}
	else
	{
		$("#wb").css("display","none");
	}
	hb=$("#icb").is(":checked");
}
function oso()
{
	jl();
	$("g").remove();
	b=parseInt($("#aoct").val());
	start();
}