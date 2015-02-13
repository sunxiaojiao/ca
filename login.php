<?php

/**
 *   登录
 * 
 */
if (isset($_POST['email']) && $_POST['passwd']!="")
{
    //检测SQL注入
    include("function.php");
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }
    
    $email = $_POST['email'];
    $passwd = md5($_POST['passwd']);
    require ('ca_dbconn.php');

    $query = "select `uid`,`username` from `user` where email='$email' and passwd='$passwd'";
    if($result = $mysqli->query($query)){
        if ($mysqli->affected_rows > 0)
        {
            $row = $result->fetch_row();
            session_start();
            $_SESSION['uid'] = $row[0];
            $_SESSION['username'] = $row[1];
            echo "<script>location.href='view.php'</script>";
        } else
        {
            echo <<<EOT
            <script>
            
            $("input[name='passwd']").val("");
            if($("input[name='uid']").val()==""){
                $("input[name='uid']").focus();
            }else{
                $("input[name='passwd']").focus();
            }
            $(".my-red").text("密码错误！");
            
            
            </script>
EOT;
        }
        
    }else{
        die("<script>alert(' ');</script>");
    }

} else
{
    echo <<<EOT
            <script>
            $("input[name='passwd']").val("");
        if($("input[name='uid']").val()==""){
            $("input[name='uid']").focus();
        }else{
            $("input[name='passwd']").focus();
        }
            $(".my-red").text("请输入账号和密码！");
            </script>
EOT;

//    header("location:ca_logup.php");
}

?>