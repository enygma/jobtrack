<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>jobtrack</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/assets/css/site.css" />
		<!--<script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>-->

		<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
		<script src="/assets/js/underscore-min.js" type="text/javascript"></script>
		<script src="/assets/js/backbone-min.js" type="text/javascript"></script>
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
					<a class="brand" href="#">JobTrack</a>
					<div class="nav-collapse">
						<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li class="active"><a href="#">Applicants</a></li>
						<li class="active"><a href="#">Positions</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="top-pad container">
		<?php echo $content; ?>
		<hr>
		<footer><p>test</p></footer>
		</div>
	</body>
	<!-- include modules -->
	<script src="/assets/js/records.js" type="text/javascript"></script>
	<script src="/assets/js/search.js" type="text/javascript"></script>

	<!-- include main app -->
	<script src="/assets/js/app.js" type="text/javascript"></script>
</html>