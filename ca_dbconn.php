<?php
/**
*数据库连接
*
*/
include("ca_config.php");

$mysqli=new mysqli($ca_dbhost,$ca_dbuser,$ca_dbpasswd,$ca_dbname,$ca_dbport);

if(mysqli_connect_error()){
    die("数据库连接失败");
}else{
    //echo "连接成功";
}
$mysqli->query("SET NAMES 'UTF8'");
?>