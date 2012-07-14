<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>jobtrack</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/assets/css/site.css" />
		<link href='http://fonts.googleapis.com/css?family=Habibi' rel='stylesheet' type='text/css'>

		<!-- load the scripts and utilities -->
		<script src="/assets/js/lib/jquery.min.js" type="text/javascript"></script>
		<script src="/assets/js/lib/underscore-min.js" type="text/javascript"></script>
		<script src="/assets/js/lib/backbone-min.js" type="text/javascript"></script>

		<script data-main="/assets/js/require-config.js" src="/assets/js/lib/require.js" type="text/javascript"></script>
		<script type="text/javascript">
			require(['lib/bootstrap-dropdown']);
			require(['records','recent','search','position','nav','app']);
		</script>
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a>
					<a class="brand" href="/">JobTrack</a>
					<div class="nav-collapse">
						<ul class="nav nav-items"></ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="top-pad container">
		<div id="messages"></div>
		<?php echo $content; ?>
		<hr>
		<footer><p>jobtrack &copy; <?php echo date('Y'); ?></p></footer>
		</div>
	</body>
	<!-- include modules -->
	
</html>