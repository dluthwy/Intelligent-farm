<?php
//连接数据库
include "conndb.php";

//查询最新数据
$sql = "SELECT Temperature,Humidity,Light,UpdateTime FROM TempHumiTable ORDER BY Id DESC LIMIT 1;";
$result = $conn->query($sql);

//读取结果
if($result->num_rows > 0){
    $row  = $result->fetch_assoc();
    $arr = array("Temp" => $row["Temperature"], "Humi" => $row["Humidity"], "Light" => $row["Light"], "Time" =>$row["UpdateTime"]);
    echo json_encode($arr);
}
//关闭数据库连接
$conn->close();
?>