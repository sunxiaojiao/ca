<?php
/**
*   此文件包含：登录判断，顶部导航，已连入数据库
*
*
*/

error_reporting(0);
//获取当前用户,若无，跳到首页
session_start();
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    include ("ca_dbconn.php");
    include ("function.php");
}else{
    header("location:index.php");
    exit("failed");
}

?>
<!DOCTYPE HTML> 
<html lang="zh-CN"> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <meta name="keywords" content="," />
    <meta name="description" content="" /> 
    <title>个人中心————--—同学录</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        div.row>div{}
        #dropdownMenu1,#dropdownMenu2{width:100%;}
        #dropdownMenu1+.dropdown-menu,#dropdownMenu2+.dropdown-menu{width:100%; text-align: center;}
        .btn-right{float:right;}
        #my-table-list tr>td{font-size: 18px; line-height: 30px;}
        #class_list .well{margin-bottom: 0; background:#222; color:#9D9D9D;}
        #class_list .dropdown{margin-bottom: 10px;}
        #my-search-r{margin-top: 10px;}
        #my-search-r>li>a{top: 5px;right: 10px;position: absolute;}
    </style>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>

<body>

    <!--==================-->
    <!--nav-start-->
    <!--==================-->
<nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">CA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php isactive("view.php");?>"><a href="view.php">查看同学录<span class="sr-only">(current)</span></a></li>
        <li><a href="#" data-toggle="modal" data-target="#join_ca">加入班级</a></li>
        <li class="divider"></li>
        <!---<li><a href="#" data-toggle="modal" data-target="#new_class">新建班级</a></li>-->
        <li class="<?php isactive("classlist.php");?>"><a href="classlist.php">班级申请</a></li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">功能<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">聚会（未开发）</a></li>
            <li><a href="#">交友（未开发）</a></li>
            <li class="divider"></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search" metod="get" action="search.php">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="学校/班级/同学" name="search">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
      </form>

      <ul class="nav navbar-nav navbar-right">
        <?php
        $query="select `username` from `user` where uid='$uid'";
        if($result=$mysqli->query($query)){
          $row=$result->fetch_row();
          echo "<li><a href='perinfo.php'>".$row[0]."</a></h1>";
        }else{
          echo "SQL syntax error";
        }
        ?>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">个人中心<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="perinfo.php">个人信息</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">注销</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!--===========================-->
<!--nav-end-->
<!--===========================-->
<!--弹出框-->
<div class="modal fade" id="new_class" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">加入班级</h4>
        <span class="my-red"></span>
      </div>
      <div class="modal-body">
        <form method="post" action="login.php" id="login">
          <div class="input-group" id="my-yorn">
            <span class="input-group-addon">学校</span>
            <input type="text" class="form-control" name="school" aria-label="Amount (to the nearest dollar)">
            <span class="input-group-addon">班级</span>
            <input type="text" class="form-control" name="class" aria-label="Amount (to the nearest dollar)">
            <span class="input-group-addon btn btn-primary" >新建</span>
          </div>
        </form>
        <!--搜索结果-->
        <div class="list-group my-search-r">
        </div>
        <!--搜素结果end-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
 </div>


  <div class="modal fade" id="join_ca" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">加入班级</h4>

      </div>
      <div class="modal-body">
        <form method="post" action="search.php">
          <div class="input-group"  id="my-search">
            <span class="input-group-addon">学校</span>
            <input type="text" name="school" class="form-control" aria-label="Amount (to the nearest dollar)">
            <span class="input-group-addon">班级</span>
            <input type="text" name="class" class="form-control" aria-label="Amount (to the nearest dollar)">
            <span class="input-group-addon btn btn-primary">搜索</span>
          </div>
        </form>
        <!--搜索结果-->
        <div class="list-group my-search-r">
        </div>
        <!--搜素结果end-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
 </div>
<!--弹出框end-->
<script>
//搜索
$("#my-search span.btn").click(
  function(){

    //GET VALUE
    var it=$(this).parent();
    var itid="#"+it.attr("id")+" ";
    console.log(itid);
    var school=$(itid+"input[name='school']").val();
    var cla=$(itid+"input[name='class']").val();
    //AJAX
    $.get(
      "search.php",
     {
      'school':school,
      'class':cla
      },
      function(data){
        it.parent().next().html(data);
      }
      )
});

//插入
$("#my-yorn span.btn").click(function(){
    //get value
    var it=$(this).parent();
    var itid="#"+it.attr("id")+" ";
    var school=$(itid+"input[name='school']").val();
    var cla=$(itid+"input[name='class']").val();
    //ajax
    $.post(
      "insert.php",
      {
        'school':school,
        'cname':cla
      },
      function(data){
        it.parent().next().html(data);
      }
      );
});

</script>
