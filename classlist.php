<?php

/**
 *  创建的班级
 */

include("header.php");

?>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="panel panel-default">
                 <div class="panel-heading">管理的班级</div>
                 <div class="panel-body">
                    <table class="table">
                        <thead><tr><td>学校</td><td>班级</td><td>申请人</td><td>申请时间</td></tr></thead>
                        <tbody>
                   
                        
            <!--result-->
<?php
$uid;
//选取用户管理的班级
$cid_list='';
$result='';
$sql="select cid from `classes` where admin_uid=$uid";
if($result=$mysqli->query($sql)){
    if($mysqli->affected_rows>0){
        while($row=$result->fetch_row()){
            $cid_list=$row[0].",";
        }
    }else{
        exit("<tr>no result111111</tr>");
        
    }
}else{
    echo "SQL error";
}

//选取申请列表
$cid_list=trim_d($cid_list);
$sql="SELECT 
classes.school,classes.cname,user.username,application.app_time,application.id,application.cid,application.app_uid
FROM application,classes,user 
WHERE application.cid in($cid_list) AND application.cid=classes.cid AND user.uid=application.app_uid ORDER BY classes.cid,user.uid";
if($result=$mysqli->query($sql)){
    if($mysqli->affected_rows>0){
        while($row=$result->fetch_assoc()){
            //打印结果
            echo "<tr><td>".$row['school']."</td><td>".$row['cname']."</td><td><a href='perinfo.php?uid=".$row['app_uid']."'>".$row['username']."</a></td><td>".$row['app_time']."<button type='button' class='btn btn-success btn-sm btn-right my-pass' goto='{$row['id']},{$row['app_uid']},{$row['cid']}'>通过</button><button type='button' class='btn btn-danger btn-sm btn-right my-refuse' goto='{$row['id']}'>拒绝</button></td></tr>";
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
<script>
//通过，拒绝
$('.my-pass,.my-refuse').click(function(){
   //获取数据
   var str=$(this).attr('goto');
   var what;
   var arr=str.split(",");
    
   if(arr.length==1){
    what="no";
   }else{
    what="yes";
   }
   console.log(what);
   //ajax
   $.get(
   "insert.php",
   {
    'goto':str,
    'yesno':what
   },
   function(data){
    $("body").append(data);
   }
   );
});
</script>

</body>
</html>