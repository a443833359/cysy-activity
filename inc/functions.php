<?php
require_once 'db.php';
require_once 'logininfo.php';
$conn=new connection($servername, $username, $password, $db, $port);
function signup($aid,$id,$name){
	global $conn;
	if (!$id or !$name or !is_numeric($id)) {
		return array("失败","输入格式错误",0);
	}
	if (isfull($aid)) {
		return array("失败","活动人数已满",0);
	}
	$allnumber=$conn -> select('activities_sign',['sid'],"aid = ".htmlspecialchars($aid));
	foreach ($allnumber as $key => $value) {
		if ($value['sid']==htmlspecialchars($id)) {
			return array("失败","已经注册该活动",0);
		}
	}
	do_signup($aid,$id,$name);
	$allnumber=$conn -> select('activities_sign',['sid'],"aid = ".htmlspecialchars($aid));
	foreach ($allnumber as $key => $value) {
		if ($value['sid']==htmlspecialchars($id)) {
			return array("成功","注册成功",1);
		}
	}
	return array("失败","内部错误",0);
}
function get_by_id($aid,$query){
	global $conn;
	$ret=$conn -> select('activities',[$query],"id = ".htmlspecialchars($aid));
		if (!$ret) {
		die("内部错误");
	}
	foreach ($ret as $key => $value) {
		return $value[$query];
	}
}
function isfull($aid){
	return (get_by_id($aid,"alimit")!=0 && get_by_id($aid,"alimit")>=get_by_id($aid,"acur"));
}
function do_signup($aid,$id,$name){
	global $conn;
	$conn -> insert('activities_sign',['aid','sid','name'],[htmlspecialchars($aid),htmlspecialchars($id),htmlspecialchars($name)]);
	$conn -> update('activities',['acur'],[get_by_id($aid,'acur')+1],"id = ".htmlspecialchars($aid));
}