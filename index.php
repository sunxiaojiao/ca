<?php error_reporting(0); session_start();?>
<!DOCTYPE HTML> 
<html lang="zh-CN"> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <meta name="keywords" content="孙小蛟,同学录" />
    <meta name="description" content="" /> 
    <title>同学录</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link href='http://www.youziku.com/webfont/CSS/80c9452318f77e60ba1bd127a7b584c6' rel='stylesheet' type='text/css'/>
    <style>
    .my-red{top: 20px;
            width: 100%;
            display: block;
            position: absolute;
            text-align: center;
            color: red;
          }
    nav.navbar{margin-bottom: 0;}
    #intro{float:right;font-size: 26px; position: relative;top:-100px;max-width:400px;}
    @media (max-width:768px){#intro{float: none;top:0;}}
    #img_list img{width:342px;}
    .footer{width:100%;height:80px; background:#101010;margin-top:20px; text-align: center;}
    .footer:before{display:table;content:" ";padding-top:10px;}
    .footer>.container:before{padding-top:10px;}
    .footer>.container:after{padding-bottom:10px;}
    .footer a{margin:0 10px;}
    #img_list div{text-align:center;font-family:minijianlinxin208582;font-size: 30px;}
    </style>
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
      <ul class="nav navbar-nav navbar-right">
        
<?php 
if(isset($_SESSION['uid'])){
  echo "<li><a href='view.php'>个人中心</a></li>";
}else{
  echo "<li class=''><a href='#'  data-toggle='modal' data-target='#login'>登录<span class='sr-only'>(current)</span></a></li>".
  "<li><a href='#'  data-toggle='modal' data-target='#register'>注册</a></li>";
}
?>
      </ul>
    </div>
  </div>
</nav>
<!--===========================-->
<!--nav-end-->
<!--===========================-->
<!--===========================-->
<div class="jumbotron">
    <div class="container">
    <h1>同学录</h1>
    <p>classmate alumni</span>
    <p>————by<a href="http://www.xiaojiaosun.com/">孙小蛟</a></p>
    <div id="intro">这个东西写了两个周多点，也是醉了。</div>
    <p><a class="btn btn-primary btn-lg" href="#" role="button"  data-toggle="modal" data-target="#register">&nbsp;注册&nbsp;</a></p>
  </div>
</div>
<!--===========================-->
<!--3 rows-->
<div class="container" id="img_list">
	<div class="row">
		<div class="col-md-4">
      同
			<p></p>
		</div>
		<div class="col-md-4">
      学
			<p></p>
		</div>
		<div class="col-md-4">
      录
		<!-- 	<img src="./images/row.jpg"/> -->
			<p></p>
		</div>

	</div>
</div>
<!--3 rows end-->
 <footer class="footer">
  <div class="container">
    <p>Copyright © 2015<a href="http://www.xiaojiaosun.com">孙小蛟</a></p>
  </div>

 </footer>
<!--弹出框-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">登录</h4>
        <span class="my-red"></span>
      </div>
      <div class="modal-body">
        <form method="post" action="login.php" id="login">
          <div class="form-group">
            <label for="recipient-name" class="control-label">EMAIL：</label>
            <input type="text" class="form-control" id="recipient-name" name="uid" />
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">密码：</label>
            <input class="form-control" id="message-text" name="passwd" type="password" />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="btn_login">登录</button>
      </div>
    </div>
  </div>
 </div>


  <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">注册</h4>
        <span class="my-red" id="r"></span>

      </div>
      <div class="modal-body">
        <form method="post" action="logup.php">
          <div class="form-group">
            <label for="recipient-name" class="control-label">姓名：</label>
            <input type="text" class="form-control" id="recipient-name" name="reg_uname" />
            <label for="message-text" class="control-label">电子邮箱：</label>
            <input class="form-control" id="message-text" name="reg_email" />
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">密码：</label>
            <input class="form-control" id="message-text" name="reg_pwd" type="password" />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="btn_reg">注册</button>
      </div>
    </div>
  </div>
 </div>


<!--弹出框end-->

    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script>
//登录
      var btn_login=$("#btn_login");
      
      btn_login.click(
        function(){
          //获取value
          var email=$("input[name='uid']").val();
          var passwd=$("input[name='passwd']").val();

          //Ajax
          $.post(
              "login.php",
              {
                'submit':email,
                'email':email,
                'passwd':passwd
              },
              function(data,status){
                $("body").append(data);
              }
            )
        });
//注册
      var btn_reg=$("#btn_reg");
      btn_reg.click(
        function(){
          //获取value
          var email=$("input[name='reg_email']").val();
          var username=$("input[name='reg_uname']").val();
          var passwd=$("input[name='reg_pwd']").val();
          console.log(email);
          //Ajax
          $.post(
            "logup.php",
            {
              'email':email,
              'username':username,
              'passwd':passwd
            },
            function(data){
              $("body").append(data);
            })



        });



    </script>
</body>

</html>