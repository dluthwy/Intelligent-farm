<?php
//GET数据变量
$TempSet = $_GET["TempSet"];
$HumiSet = $_GET["HumiSet"];
$AutoLight = $_GET["AutoLight"];

if($TempSet == NULL || $HumiSet == NULL || $AutoLight == NULL){
    die("请求参数为空");
}else{
    $arr = array("TempSet"=>$TempSet, "HumiSet"=>$HumiSet, "AutoLight"=>$AutoLight);
    echo json_encode($arr);
}
//连接数据库
include "conndb.php";

//更新配置文件
$sql = "UPDATE ConfigSet SET TempSet='".$TempSet."',HumiSet='".$HumiSet."',AutoLight='".$AutoLight."' WHERE Id='1';";
$result = $conn->query($sql);

//关闭数据库连接
$conn->close();
?>