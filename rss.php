<?php
	$db_host = "localhost"; // Giữ mặc định là localhost
	$db_name    = 'muanemtr_wean';// Ten database cua ban
	$db_username    = 'muanemtr_wean'; // Ten dang nhap database cua ban
	$db_password    = '123abc!!!';// Mat khau dang nhap database cua ban
	@mysql_connect("{$db_host}", "{$db_username}", "{$db_password}") or die("Không thể kết nối database");
	@mysql_select_db("{$db_name}") or die("Không thể chọn database");
	mysql_query("SET NAMES 'utf8'");
	$sqlNewsStr ="SELECT * FROM products ORDER BY id DESC"; // "xxx" là bảng chứa nội dung của website trong database
	$NewsRS = mysql_query($sqlNewsStr);
?>
<?php 
   	 	header('Content-Type: text/xml; charset=utf-8');
    	echo ('<?xml version="1.0" encoding="utf-8" ?>');
    	echo ('<rss version="2.0" xmlns:atom="****://www_w3_org/2005/Atom" >');
    	echo ('<channel>'); 
    	echo('<title><![CDATA[Công ty nệm | đại lý nệm | mua nệm trả góp]]></title>');
        echo('<link><![CDATA[http://congtynem.com/vi]]></link>');
        echo('<description><![CDATA[Gia công mỹ nghệ uy tín và chất lượng]]></description>');
  
        if($NewsRS){
        while ($row = mysql_fetch_array($NewsRS)){
        	$alias	= $row['alias'];
        	$menu	= $row['menu_id'];
        	$id		= $row['id'];
        	$link = 'http://congtynem.com/vi/san-pham'. '-' . $menu . '-' . $id . '/' . $alias . '.html';
        	$description		= str_replace("\\","",$row['description_html']);
	        echo('<item>');
	        echo ('<title><![CDATA[').str_replace("\\","",$row['name']).(']]></title><br/>');
	        echo ('<link><![CDATA[').$link.(']]></link><br/>');
	        echo ('<description><![CDATA[');
	        echo strip_tags($description);
	        echo (']]></description><br/>');
	        echo ('</item>');
        }
        }

echo ('</channel>');
echo ('</rss>');
?>