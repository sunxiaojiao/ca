<?php

/**
 * 查看同学录
 */


?>

<?php
//引入顶部导航，数据库连接，登录判断
include("header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-3" id="class_list">
            <div class="well well-sm">所在的班级</div>
            <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    选择班级
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <?php
                    //列出所在班级
                    $query = "select classes from `user` where uid={$uid}";
                    $result = $mysqli->query($query);
                    $class_str = $result->fetch_row();
                    $class_str = $class_str[0];
                    $class_str = trim_d($class_str);
                    //使用in 效率较低
                    $query = "select cid,cname,school from `classes` where cid in($class_str)";
                    $result = $mysqli->query($query);
                    if($result){
                      if($mysqli->affected_rows){
                          while ($row = $result->fetch_assoc())
                          {
                         echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?cid='.$row['cid']."'>".$row['school'].$row['cname']."</a></li>"; 
                          }
                        }else{
                          echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='javascript:void'>无</a></li>";
                        }
                     }else{
                     //若没有
                     echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='javascript:void'>无</a></li>";
                      }
                    ?>
                  </ul>
            </div>
            <div class="well well-sm">管理的班级</div>
            <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
                    选择班级
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                   <?php 

                   //列出管理的班级
                  $query = "select cid,cname,school from `classes` where admin_uid={$uid}";
                  $result = $mysqli->query($query);
                  if($result){
                      if($mysqli->affected_rows){
                          while ($row = $result->fetch_assoc())
                            {

                              echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?cid=".$row['cid']."'>".$row['school'].$row['cname']."</a></li>";
                            }
                          }else{
                             echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='javascript:void'>无</a></li>";
                          }
                  }else{
                      //没有班级
                      echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='javascript:void'>无</a></li>";
                      }
                  ?>                 
                </ul>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-hover" id="my-table-list">
                        <thead>
                            <tr><td>姓名</td><td>电话</td><td>地址</td></tr>
                        </thead>
                        <tbody>
                          <?php
                          //由班级获取班级内成员列表及信息
                            $uid_str='';
                            if(isset($_GET['cid']) && $_GET['cid'] != ''){
                                $sel_cid=$_GET['cid'];
                                //检测SQL注入
                                if(check_sql_inject()){
                                    exit("<script>alert('非法字符！');location.href='index.php';</script>");
                                }
                                //检测是否为班内成员
                                //$query="select `uid` from `classes` where cid={$sel_cid}";
                                //$row=$mysqli->query($query)->fetch_row();
                                $query="select `uid` from `user` where uid in (select `uid` from `classes` where cid={$sel_cid}) and uid={$uid}";
                                if($mysqli->query($query)){
                                   if(!$mysqli->affected_rows){
                                    
                                    exit("<tr><td>您没有查看此班级成员的权限</td></tr>");
                                   }
                                }else{
                                  die("SQL error1");  
                                }
                                 
                                $query = "select `uid` from `classes` where cid=$sel_cid";
                                if($result = $mysqli->query($query)){
                                  if($mysqli->affected_rows>0){
                                    $uid_arr = $result->fetch_row();
                                    $uid_str = $uid_arr[0];
                                    $uid_str = trim_d($uid_str);
                                  }else{
                                    echo "error，没有成员";
                                  }

                                }else{
                                  echo "SQL error";
                                }

                              $query = "select `uid`,`username`,`telephone`,`address` from `user` where uid in ($uid_str)";
                              if($result = $mysqli->query($query)){
                                if($mysqli->affected_rows>0){

                                  while ($uid_arr = $result->fetch_assoc())
                                  {
                                    echo "<tr><td>".$uid_arr['username']."</td><td>".$uid_arr['telephone']."</td><td>".$uid_arr['address']."<a  class='btn btn-success btn-sm btn-right' href='perinfo.php?uid={$uid_arr['uid']}'>详细</a></td>
                                    </tr>";
                                  } 

                                }else{
                                  echo "error，没有成员";
                                }
                              }else{
                                //$uid_str为空，打印管理员的信息
                                $query="select `uid`,`username`,`telephone`,`address` from `user` where uid=(select `admin_uid` from `classes` where cid=$sel_cid) ";
                                if($result=$mysqli->query($query)){
                                  $uid_arr=$result->fetch_assoc();
                                  echo "<tr><td>".$uid_arr['username']."</td><td>".$uid_arr['telephone']."</td><td>".$uid_arr['address']."<a  class='btn btn-success btn-sm btn-right' href='perinfo.php?uid={$uid_arr['uid']}'>详细</a></td>
                                    </tr>";
                                }else{
                                  echo "SQL error";
                                }
                              }

                            
                            }else{ 

                             }
                            ?>
                          
                        </tbody>
                        
                    </table>
                </div>
            </div>

        </div>
    </div>   
</div>
</body>

</html>