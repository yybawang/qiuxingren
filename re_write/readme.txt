IIS Re_write ���

��װ˵����

1����IIS��Isapi��������ɸѡ����ɸѡ������ re����ִ���ļ�ѡ�� Rewrite.dll����

2������httpd.ini�ļ�

RewriteRule /news/(\d+)\.html /jsp/news\.jsp\?id=$1 [N,I]
��ʾ��news.jsp?id=95 ת����news/95.html

�Դ����ƣ�������и���Ĳ�������������Ӧ��(\d+)���������id=$1��������id=$2,�ȵȡ�


Ŀǰ��Ϊ�ձ�Ķ�̬��ҳ����asp,php,jsp,shtml,jhtml,cgi......
��������һЩ�Լ�����ģ����磺aspx,do,index,hello�ȵȡ�
������ʽΪ��news.asp?id=95���������ͨ��re_write����ת����news/95.html���Ա���google�Ը���ҳ��ʶ��

����Ҫ��news.jsp?id=95��ӳ���news/95.htmlʱ��ֻ������httpd.ini�ļ���
RewriteRule /news/(\d+)\.html /news\.jsp\?id=$1 [N,I]
�����Ͱ� /news/95.html ����������ӳ����� /news.jsp?id=95

Ȼ���������Ӵ�����д��<a href='/news/95.html'>95����</a>��
������������ͨ�����ݿ�ѭ����ȡ�����ģ���ôд���ǣ�
while(rs.next())
{
String id = (String)rs.getString('id');
out.print('<a hef='/news/''+id+'.html>');
out.print('95����');
out.print('</a>');
}

������ڴ������ݷ�ҳ����ôд���ǣ�

More_<%=Page%>_<%=type%>.html ��ע��page�Ƿ�ҳҳ����type���������ͣ�
������ʽ��More_1_95.html

�������һҳ����Ϊ��More_2_95.html��������һҳ��ѭ�������ǣ�
More_3_95.html���Դ����ơ�

��������Ҫ��httpd.ini�ļ����������´��룺
RewriteRule /More_(\d+)_(\d+)\.html /jsp/more\.jsp\?page=$1&type=$2 [N,I]

�����Ķ�̬�����ж��������Ҫ���ݣ���ô�����Ӷ��(\d+)���ɣ����£�

RewriteRule /More_(\d+)_(\d+)_(\d+)\.html /jsp/more\.jsp\?page=$1&type=$2&type2=$3 [N,I]

��ҳ���������ʽ�ǣ�More_1_95.html