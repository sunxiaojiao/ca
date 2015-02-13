<?php

/**
 * 插入用户（分别插入到用户表和班级表）
 */

function admin_insert($uid, $cid)
{

    // 插入用户到班级表中
    include("ca_dbconn.php");
    $query = "select `uid` from `classes` where cid=$cid";
    if($result = $mysqli->query($query)){
        if($mysqli->affected_rows>0){
            $row = $result->fetch_row();
            $uids_str = $row[0]; //存储用户的字符串
            //更新字符串
            $uids_str = $row[0] . $uid . ",";
            //更新班级表和用户表
            $query = "update `classes` set `uid`='$uids_str' where cid=$cid";
            if(!$mysqli->query($query))
                return false;

        }else{
           echo "no this uid in table `classes`";
           return false;       
        }
                    
            
    }else{
        //echo "function.php SQL error".$mysqli->errno;
        //return false;
    }
    
    


    //插入班级到用户表中

    $query = "select `classes` from `user` where uid=$uid";
    if($result = $mysqli->query($query)){
        if($mysqli->affected_rows>0){
            $row = $result->fetch_row();
            $row[0]; //存储班级的字符串
            //更新字符串
            $classes='';
            $classes .= $row[0] . $cid . ",";
            //更新班级表和用户表
            $query = "update `user` set `classes`='$classes' where uid=$uid";
            if($mysqli->query($query)){
                return true;
            }else{
                return false;
            }
        }else{
            echo "no this cid in table `classes`";
            return false;
        }
        
    }else{
        echo "function.php SQL error";
        return false;
    }
    
    
    
    $mysqli->close();
}

/**
*   去掉传入字符串最后一个英文逗号
*
*/
function trim_d($str){
     return substr($str,0,strlen($str)-1);
}

/**
*   检测sql注入
*   若存在注入，返回true
*
*/
function check_sql_inject(){
    //非法字符正则
    $notall='/select|insert|update|delete|and|or|\'|\/\*|\*|\.\.\/|\.\/|;|union|into|load_file|outfile/';
    //对GET进行匹配
    foreach($_GET as $key=>$value){
        if(preg_match($notall,$value)){
            return true;
        }
    }
    //对POST进行匹配
    foreach($_POST as $key=>$value){
        if(preg_match($notall,$value)){
            return true;
        }
    }
    return false;
}
/**
*   添加  CSS class active
*
*/
function isactive($filename){
    $nowfile = $_SERVER['PHP_SELF'];
    $nowfile = explode("/",$nowfile);
    $nowfile=$nowfile[count($nowfile)-1];
    if($nowfile == $filename){
        echo "active";
    }
}
?>