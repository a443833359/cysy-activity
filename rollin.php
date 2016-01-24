<?php
//Shit code
require_once 'inc/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>活动报名</title>
	<link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
	<style>
		*{
			font-family: "Microsoft Yahei";
		}
	</style>
	<script>
	<?php if(isset($_GET['id']) and isset($_GET['name'])) { ?>
		$(function(){
			$('#myModal').modal();
		});
	<?php } ?>
	</script>
</head>
<body>
	<?php if(isset($_GET['id']) and isset($_GET['name'])) {
		$rta=signup($_GET['aid'],$_GET['id'],$_GET['name']);
	?>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $rta[0]; ?></h4>
				</div>
				<div class="modal-body">
					<p>
					<?php echo $rta[1]; if ($rta[2]) { ?>
					</p>
					<p>学号:<?php echo $_GET['id']?></p>
					<p>姓名:<?php echo $_GET['name']?></p>
					<?php } ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(isset($_GET['aid']) and get_by_id($_GET['aid'],"aname")); { ?>
	<div class="container">
		<form action="">
			<div class="form-group">
				<h3 class="activity-name">
					<?php echo get_by_id($_GET['aid'],"aname"); ?>
				</h3>
				<p class="activity-limit">
					参加人数 <?php echo get_by_id($_GET['aid'],"acur")." / ".get_by_id($_GET['aid'],"alimit"); ?>
				<p>
				<input type="hidden" name="aid" value="<?php echo $_GET['aid'] ?>">
			</div>
			<div class="form-group"><label for="id">学号</label><input type="text" class="form-control" name="id"></div>
			<div class="form-group"><label for="name">姓名</label><input type="text" class="form-control" name="name"></div>
			<input type="submit" class="btn btn-success form-control">
		</form>
	</div>
	<?php } ?>
</body>
</html>