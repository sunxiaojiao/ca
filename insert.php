<?php
/**
*	插入数据
*   
*
*/

//判断是否登录
session_start();
if(isset($_SESSION['uid'])){
	$uid=$_SESSION['uid'];
}else{
	die("未登录");
}
include("ca_dbconn.php");
include("function.php");

//加入班级
if(isset($_GET['cid']) && $_GET['cid'] != ''){
    
    //检测SQL注入
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }
    $cid=$_GET['cid'];
	$sql="insert into application (`cid`,`app_uid`) values($cid,$uid)";
    if($mysqli->query($sql)){
        echo <<<ETO
        <script>
        $(".my-join[goto='$cid']").before("<span class='label label-default'>申请成功</span>");
        $(".my-join[goto='$cid']").addClass("disabled");
        </script>
ETO;
    }else{
        echo "SQL error";
    }
	
}


//新建班级
if(isset($_POST['cname']) && isset($_POST['school'])){
    //判断是否非空
    if($_POST['cname'] == '' || $_POST['school'] == ''){
        $str="请输入完整";
        die($str);
    }else{
        $cname=$_POST['cname'];
        $school=$_POST['school'];
    }
    //检测SQL注入
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }
    //与搜索时的时间戳和内容进行比较
    if(isset($_SESSION['search'])){
        //时间检测
        $time_now=time();
        $time_search=$_SESSION['search']['time'];
        if($time_now<$time_search){
            exit("新建班级非法");
        }
        //内容检测,不太合理
        $con_search=$_SESSION['search']['content'];
        $con_now=$school.$cname;
        if($con_now != $con_search){
           exit("新建班级非法（先确认此班级是否存在）");
        }


    }else{
        die("新建班级非法，请先搜素确定是否已存在此班级");
    }

    //插入
    $time=time();
    $sql="insert into classes (`admin_uid`,`cname`,`school`,`create_time`) values ($uid,'$cname','$school',$time)";
    if($mysqli->query($sql)){
        $sql="select `cid` from `classes` where cname='$cname' and create_time=$time";
        $cid=0;
        if($result=$mysqli->query($sql)){
            $row=$result->fetch_row();
            $cid=$row[0];
        }else{
            die("SQL error");
        }
        
        if(admin_insert($uid,$cid)){
             $str="新建班级成功";
             echo $str; 
        }
    }else{
        $str="SQL error";
        echo $str;
        echo $sql;
    }
    
}

//申请表
if(isset($_GET['yesno']) && $_GET['yesno'] != ''){
//申请通过
    //检测SQL注入
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }
    $str=$_GET['goto'];
    $arr=split(",",$str);
    //var_dump($arr);
    if($_GET['yesno']=='yes'){
        $app_uid=$arr[1];
        $app_cid=$arr[2];
        if(admin_insert($app_uid,$app_cid)){
            echo "添加成功";
        }else{
            die("添加错误");
        }
    }    
//申请拒绝
    $sql="DELETE FROM application where id=$arr[0]";
    if(!$mysqli->query($sql)){
        echo "删除失败";
    }else{
        echo "success";
    }
}