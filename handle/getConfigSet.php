<?php
//连接数据库
include "conndb.php";

//查询配置文件
$sql = "SELECT TempSet,HumiSet,AutoLight FROM ConfigSet LIMIT 1;";
$result = $conn->query($sql);

//读取结果
if($result->num_rows > 0){
    $row  = $result->fetch_assoc();
    $arr = array("TempSet" => $row["TempSet"], "HumiSet" => $row["HumiSet"], "AutoLight" => $row["AutoLight"]);
    echo json_encode($arr);
}

$conn->close();
?>