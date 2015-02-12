<?php

/**
 *  注册
 */

if(isset($_POST['email']) && isset($_POST['passwd']) && isset($_POST['username'])){
    if($_POST['email'] =='' || $_POST['passwd'] == '' || $_POST['username'] ==''){
        $str=<<<EOT
            <script>
            
            if($("input[name='reg_uname']").val()==""){
                $("input[name='reg_uname']").focus();
            }else if($("input[name='reg_email']").val()==""){
                $("input[name='reg_email']").focus();
                }else{
                    $("input[name='reg_pwd']").focus();
                }
            $("#r").text("请完整填写信息！");
            
            
            </script>
EOT;
        exit($str);
    }elseif(preg_match("/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/",$_POST['email'])){
        session_start();
        }else{
            exit("$<script>$('#r').text('您填写的邮箱格式不正确！');</script>");
        }
    
    $username=$_POST['username'];
    $passwd=md5($_POST['passwd']);
    $email=$_POST['email'];

    require_once('ca_dbconn.php');
    $query="insert into `user` (username,passwd,email,reg_time) values('$username','$passwd','$email',now())";
    //$query="set names utf8;".$query;
    if($mysqli->query($query)){
        
        echo 'insert successfully';
        $query="select `uid` from `user` where username='$username' and passwd='$passwd'";
        $result=$mysqli->query($query);
        $rows=$result->fetch_row();
        echo $rows[0];
        $_SESSION['uid']=$row[0];
        echo "<script>alert('your uid is $rows[0]');location.href='view.php';</script>";
        
        
        
    }else{
        echo 'faild to insert';
    }
    
}else{
    echo "<script>alert('填写完整的信息')</script>";
}




?>