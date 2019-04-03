<?php
header('Content-Type:text/html;charset=utf-8');

//封装函数：载入HTML模板文件
function show(){
    $error = $GLOBALS["error"];//从全局变量读取错误信息
    define("APP","db_business");
    require "index.php";
    die;//终止程序继续执行
}

// //没有表单提交时，显示注册页面
if(empty($_POST)){
    //die('没有表单提交，程序退出');
    show();
}

// //执行到此处说明有表单提交

$error=array();//保存错误信息

//判断表单中各字段是否都已填写
$check_field=array("phone","addr","ad","ae");
foreach($check_field as $v){
    if(empty($_POST[$v])){
        //echo "<script>alert('错误:".$v."字段不能为空');history.back();</script>";
       $error[]=("错误:".$v."字段不能为空");
 
       }
}

if(!empty($error)){
  show();//显示错误信息并停止程序
}




//接收需要处理的表单字段
 $phone=$_POST["phone"];
 $addr=$_POST["addr"];
 $ad=$_POST["ad"];
 $ae=$_POST["ae"];


//连接数据库，设置字符集，选择数据库
mysql_connect("localhost","root","root") or die("数据库连接失败");
mysql_query("set names utf8");
mysql_query("use db_business") or die("数据库不存在");

//sql防注入
$phone=mysql_real_escape_string($phone);
$addr=mysql_real_escape_string($addr);
$ad=mysql_real_escape_string($ad);
$ae=mysql_real_escape_string($ae);


//拼接SQL语句
$sql="insert into user (phone,addr,ad,ae) values ('$phone','$addr','$ad','$ae')";

//执行SQL语句
$rst = mysql_query($sql);

//输出执行的SQL语句和执行结果，调试程序
// echo "SQL语句：$sql<br>";
// if($rst){
// 	echo '执行成功';
// }else{
// 	echo '执行失败：'.mysql_error();
// }

//表单验证
// function checkUsername($username){
//     if(!preg_match("/^[\w\x{4e00}-\x{9fa5}]{2,10}$/u",$username)){
//         return "用户名格式不对";
//     }
//     return true;
// }

// function checkPhone($phone){
//    if(!preg_match("/^1[358]\d{9}$/",$phone)){
//     return '手机号码格式不符合要求';
// }
//    return true;


// }

// //验证用户名和密码格式
// if(($result=checkUsername($username))!== true) $error[] = $result;
// if(($result=checkPhone($phone)) !== true) $error[] = $result;
// if(!empty($error)){
//     show();
// }


//输出执行的SQL语句和执行结果
if($rst){

    // //用户注册成功，自动登录
    // session_start();
    // $id = mysql_insert_id();
	
	// $_SESSION['userinfo'] = array(
	// 	'id' => $id,				//将用户id保存到SESSION
	// 	'username' => $username		//将用户名保存到SESSION
    // );
    echo "

    <script>alert('执行成功')</script>";  
    
}
else{
    $error[]="领取失败";
    show();//显示错误信息并停止程序
}
?>