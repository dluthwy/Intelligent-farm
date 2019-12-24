<?php
//获取要查询的数据范围
$Scope = $_GET["Scope"];
//0 => 过去1小时
//1 => 过去24小时
//2 => 过去10天
if($Scope == NULL){
    $Scope = 0;
}

//连接数据库
include "conndb.php";

//创建查询SQL
if($Scope == 0){
    $sql = "SELECT YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime),HOUR(UpdateTime),MINUTE(UpdateTime),AVG(Temperature),AVG(Humidity) FROM TempHumiTable GROUP BY YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime),HOUR(UpdateTime),MINUTE(UpdateTime);";
}else if($Scope == 1){
    $sql = "SELECT YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime),HOUR(UpdateTime),AVG(Temperature),AVG(Humidity) FROM TempHumiTable GROUP BY YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime),HOUR(UpdateTime);";
}else{
    $sql = "SELECT YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime),AVG(Temperature),AVG(Humidity) FROM TempHumiTable GROUP BY YEAR(UpdateTime),MONTH(UpdateTime),DAY(UpdateTime);";
}
$result = $conn->query($sql);

//读取结果
if($result->num_rows > 0){
    $resultArray = array();
    while($row = $result->fetch_assoc()){
        if($Scope == 0){        //按分钟查询
            $Time = $row["YEAR(UpdateTime)"].'-'.$row["MONTH(UpdateTime)"].'-'.$row["DAY(UpdateTime)"].' '.$row["HOUR(UpdateTime)"].':'.$row["MINUTE(UpdateTime)"].':00';
        }else if($Scope == 1){  //按小时查询
            $Time = $row["YEAR(UpdateTime)"].'-'.$row["MONTH(UpdateTime)"].'-'.$row["DAY(UpdateTime)"].' '.$row["HOUR(UpdateTime)"].':00:00';
        }else{                  //按天查询
            $Time = $row["YEAR(UpdateTime)"].'-'.$row["MONTH(UpdateTime)"].'-'.$row["DAY(UpdateTime)"].' 00:00:00';
        }
        $rowArray = array("Time"=>strtotime($Time), "AveTemp"=>$row["AVG(Temperature)"], "AveHumi"=>$row["AVG(Humidity)"]);
        $resultArray[] = $rowArray;
    }
    //按时间倒序排列
    array_multisort(array_column($resultArray,'Time'), SORT_DESC, $resultArray);
    //分割长度
    $limitLength = array(3600, 24*3600, 10*24*3600);
    $limitTime = $resultArray[0]['Time'] - $limitLength[$Scope];
    $finalArray = array();
    foreach($resultArray as $result){
        if($result['Time'] > $limitTime){
            $result['Time'] = date("Y-m-d H:i:s", $result['Time']);
            $finalArray[] = $result;
        }
    }
    echo json_encode($finalArray);
}else{
    echo NULL;
}
//关闭数据库连接
$conn->close();
?>