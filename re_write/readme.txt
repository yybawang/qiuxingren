IIS Re_write 插件

安装说明：

1、在IIS的Isapi上添加这个筛选器，筛选器名称 re，可执行文件选择 Rewrite.dll　；

2、设置httpd.ini文件

RewriteRule /news/(\d+)\.html /jsp/news\.jsp\?id=$1 [N,I]
表示将news.jsp?id=95 转换成news/95.html

以此类推，如果你有更多的参数，则增加相应的(\d+)，而后面的id=$1，则增加id=$2,等等。


目前较为普遍的动态网页包括asp,php,jsp,shtml,jhtml,cgi......
甚至还有一些自己定义的，比如：aspx,do,index,hello等等。
表现形式为：news.asp?id=95。建议读者通过re_write将其转换成news/95.html，以便于google对改网页的识别。

当需要将news.jsp?id=95的映射成news/95.html时，只需设置httpd.ini文件：
RewriteRule /news/(\d+)\.html /news\.jsp\?id=$1 [N,I]
这样就把 /news/95.html 这样的请求映射成了 /news.jsp?id=95

然后你在连接处这样写：<a href='/news/95.html'>95新闻</a>。
如果你的新闻是通过数据库循环读取出来的，那么写法是：
while(rs.next())
{
String id = (String)rs.getString('id');
out.print('<a hef='/news/''+id+'.html>');
out.print('95新闻');
out.print('</a>');
}

如果你在处理数据翻页，那么写法是：

More_<%=Page%>_<%=type%>.html （注：page是翻页页数，type是数据类型）
表现形式：More_1_95.html

如果翻下一页，则为：More_2_95.html，继续下一页的循环，则是：
More_3_95.html，以此类推。

不过你需要在httpd.ini文件中增加以下代码：
RewriteRule /More_(\d+)_(\d+)\.html /jsp/more\.jsp\?page=$1&type=$2 [N,I]

如果你的动态程序有多个参数需要传递，那么就增加多个(\d+)即可，如下：

RewriteRule /More_(\d+)_(\d+)_(\d+)\.html /jsp/more\.jsp\?page=$1&type=$2&type2=$3 [N,I]

翻页处理表现形式是：More_1_95.html