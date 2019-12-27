<?php
$servername = "localhost";
$username = "IFUserName";
$passwd = "IFPassword";
$dbname = "IntelligentFarming";

//创建连接
$conn = new mysqli($servername, $username, $passwd, $dbname);

//检测连接
if($conn->connect_error){
    die("数据库连接失败：".$conn->connect_error);
}
//echo "连接成功";
?>
