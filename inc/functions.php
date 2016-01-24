<?php
require_once 'db.php';
require_once 'logininfo.php';
$conn=new connection($servername, $username, $password, $db, $port);
function get_aname_by_id($aid)
{
	global $conn;
	$aname=$conn -> select('activities',['aname'],"id = ".htmlspecialchars($aid));
	if (!$aname) {
		return 0;
	}
	foreach ($aname as $key => $value) {
		return $value['aname'];
	}
}
function signup($aid,$id,$name){
	global $conn;
	if (!$id or !$name or !is_numeric($id)) {
		return array("失败","输入格式错误",0);
	}
	$allnumber=$conn -> select('activities_sign',['sid'],"aid = ".htmlspecialchars($aid));
	foreach ($allnumber as $key => $value) {
		if ($value['sid']==htmlspecialchars($id)) {
			return array("失败","已经注册该活动",0);
		}
	}
	$conn -> insert('activities_sign',['aid','sid','name'],[htmlspecialchars($aid),htmlspecialchars($id),htmlspecialchars($name)]);
	$allnumber=$conn -> select('activities_sign',['sid'],"aid = ".htmlspecialchars($aid));
	foreach ($allnumber as $key => $value) {
		if ($value['sid']==htmlspecialchars($id)) {
			return array("成功","注册成功",1);
		}
	}
	return array("失败","内部错误",0);
}
