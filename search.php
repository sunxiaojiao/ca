<?php

/**
 * 搜索
 */
error_reporting(0);
session_start();
include("header.php");
if(isset($_GET['search']) /*&& $_GET['search'] !=null*/){
    //检测SQL注入
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }

    $q=$_GET['search'];
    $query="select classes.cname,classes.school,user.username,user.uid,classes.create_time from `classes`,`user` where (user.username like  '%".$q."%' or classes.cname like '%".$q."%' or classes.school like '%".$q."%') or classes.admin_uid=user.uid";
          
?>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="panel panel-default">
                 <div class="panel-heading">搜索结果</div>
                 <div class="panel-body">
                    <table class="table">
                        <thead><tr><td>学校</td><td>班级</td><td>管理者</td><td>成立时间</td></tr></thead>
                        <tbody>  
                    <!--result-->
                    <?php
                    if($result=$mysqli->query($query)){
                        if($q==''){
                            exit();
                        }
                        if($mysqli->affected_rows>0){
                            
                           while($row=$result->fetch_assoc()){
                            echo "<tr><td>".$row['school']."</td><td>".$row['cname']."</td><td><a href='perinfo.php?uid=".$row['uid']."'>".$row['username']."</a></td><td>".date("y/m/d",$row['create_time'])."</td></tr>";
                        
                             }
                            
                        }else{
                            echo "<tr><td>无</td></tr>";
                        }
                    }else{
                        echo "SQL error";
                    }
               
                    ?>

                    <!--result-end-->
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    
    
    </div>


</div>
    </body>
</html>

<?php }?>





<?php
//检测班级是否存在
if(isset($_GET['class']) && isset($_GET['school'])){
            //判断用户输入字段是否非空
            if($_GET['class']=="" || $_GET['school']==""){
                die("请输入完整信息");
            }
            //检测SQL注入
            if(check_sql_inject()){
                exit("<script>alert('非法字符！');location.href='index.php';</script>");
            }

            $cla=$_GET['class'];
            $school=$_GET['school'];
            $sql="select school,cname,cid from `classes` where cname like '%$cla%' and school like '%$school%'";
            $result=$mysqli->query($sql);
            if($result){
               
                //js1
                $js1=<<<ETO
                <script>
                //加入班级
                $(".my-join").click(function(){
                  //get value from tag a
                  var cid=$(".my-join").attr('goto');
                  //ajax
                  $.get(
                    "insert.php",
                    {
                      'cid':cid
                    },
                    function(data){
                      $("body").append(data);
                    }
                  )
                });

                </script>

ETO;
                //js2
                $js2=<<<ETO
                <script>
                $(".my-newclass").click(function(){
                    $("#join_ca").modal("hide");
                    $("#new_class").modal("show");
                });
                </script>
ETO;
                
                if($mysqli->affected_rows>0){
                    while ($row=$result->fetch_row()) {
                        echo "<li class='list-group-item'>".$row[0].$row[1]."<a class='btn btn-sm btn-success my-join' role='button' goto='$row[2]'>加入</a></li>".$js1;
                    }
                }else{
                    echo "<li class='list-group-item'>无结果,请新建班级<a class='btn btn-sm btn-success my-newclass' href='#'>新建</a></li>".$js2;
                     //没有搜索结果时，添加一个session 保存搜索的时间和搜索的班级
                        $time=time();
                        $arr_search=array('time'=>$time,'content'=>$school.$cla);
                        $_SESSION['search']=$arr_search;
                }


            }else{
                echo "SQL error";
            }

        }





?>