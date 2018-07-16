<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Bootstrap 3 Template</title>
	<meta name="generator" content="Bootply" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="<?php echo config_item('assets'); ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo config_item('assets'); ?>css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php echo config_item('assets'); ?>css/bootstrap-select.css" rel="stylesheet">
    <link href="<?php echo config_item('assets'); ?>css/bootstrap-datepicker3.css" rel="stylesheet">
    <link href="<?php echo config_item('assets'); ?>css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="<?php echo config_item('assets'); ?>images/logo.png" width="100"></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Home</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul id="hr-sub-menu" class="dropdown-menu navbar navbar-inverse">
							<li><a href="#"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Home</a></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<img src="<?php echo config_item('assets'); ?>images/Koala.jpg" class="img-circle" width="35" height="35" style="margin:2px;border:2px solid #514d4d;">
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Hi, Administrator <b class="caret"></b></a>
						<ul class="dropdown-menu sub-menu2">
							<li><a href="#"><i class="glyphicon glyphicon-user pull-right"></i>Profile</a></li>
							<li><a href="#"><i class="glyphicon glyphicon-log-out pull-right"></i>Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="#">Library</a></li>
		  <li class="active">Data</li>
		</ol>
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Select Date Recording</h2>
						</div>
						<div class="panel-body">
							<div class="col-xs-3">
								<input type="text" id="getDatePull" class="form-control" placeholder="Select Date"/>
							</div>
							<div class="col-xs-3">
								<input type="text" id="getFromApply" class="form-control" placeholder="Select Time From"/>
							</div>
							<div class="col-xs-3">
								<input type="text" id="getToApply" class="form-control" placeholder="Select Time To"/>
							</div>
							<div class="col-xs-3">
								<button type="button" class="form-control btn btn-primary" onclick="grabRecordByDate();"><i class="glyphicon glyphicon-floppy-save"></i> Export</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<br/>
			<br/>
			<div class="row">
				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Download File Records</h2>
						</div>
						<form class="panel-body" action="<?php echo base_url(); ?>telephony/copy_file_nmf" method="POST" enctype="multipart/form-data">
							<div class="col-xs-3">
								<select name="type_file" required>
									<option value="1">Only Voice</option>
									<option value="2">Voice And Video</option>									
								</select>
							</div>
							<div class="col-xs-3">
								<input type="file" name="upload_data" placeholder="Select Folder"/>
							</div>
							<div class="col-xs-3">
								<input type="text" name="path_folder" class="form-control" placeholder="Select Folder To Save"/>
							</div>
							<div class="col-xs-3">
								<button type="submit" class="form-control btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Export</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<script src="<?php echo config_item('assets'); ?>js/jquery.1.12.4.js"></script>
	<script src="<?php echo config_item('assets'); ?>js/bootstrap.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/bootstrap-select.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/bootstrap-datepicker.js"></script>
    <script>
	    $('#getDatePull').datepicker({
	            todayBtn: true,
			    clearBtn: true,
			    autoclose: true,
			    todayHighlight: true
	    });

	    function grabRecordByDate() {
			var getDateApply = $("#getDatePull").val();
			var getFromApply = $("#getFromApply").val();
			var getToApply = $("#getToApply").val();
			document.location.href = '<?php echo site_url("telephony/telephonyTrunk"); ?>?getDateApply=' + getDateApply + '&getFromTime=' + getFromApply + '&getToTime=' + getToApply;
		}
    </script>
	</body>
</html>