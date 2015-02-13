<?php
/**
*	个人信息
*
*
*/
include("header.php");
if(isset($_GET['uid']) && $_GET['uid'] != ''){
	//检测SQL注入
    if(check_sql_inject()){
        exit("<script>alert('非法字符！');location.href='index.php';</script>");
    }
    $uid=$_GET['uid'];
}

?>
<style>
	.my-perinfo>div{margin:10px 0;}
	.my-perinfo>div>span.input-group-addon{width:120px;}

</style>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-9">
			<!--info-->
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php
				$sql="select `username` from `user` where uid=$uid";
				if($result=$mysqli->query($sql)){
					$row=$result->fetch_row();
					echo $row[0];
				}else{
					echo "SQL error";
				}
				?>
				</div>

				<div class="panel-body my-perinfo">
				<?php
				$sql="select IF(sex=0,'男',IF(sex=1,'女','保密')) as 性别,age as 年龄,email as 电子邮箱,telephone as 电话,qq as QQ,address as 常居地址,work as 工作或学校 from `user` where uid=$uid";
				if($result=$mysqli->query($sql)){
					while($row=$result->fetch_assoc()){
						foreach($row as $key=>$value){
                            if($value==''){
                                $value="未填写";
                            }
							$str=<<<ETO
					<div class="input-group">
					  <span class="input-group-addon">$key</span>
					  <span class="form-control">$value</span>
					</div>	

ETO;
							echo $str;
						
						}

					}
				}else{
					echo "SQL error";
				}



				?>
					
				
				</div>

			</div>


			<!--info-end-->
		</div>


	</div>


</div>

	</body>
</html>