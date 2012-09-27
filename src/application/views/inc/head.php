
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Orbital Bridge</title>
	<meta name="description" content="The Common Web Design is the new branding for the University of Lincoln's online services">
	<meta name="author" content="Online Services Team; ost@lincoln.ac.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>/icon.png">

	<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>/cwd.css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet" type="text/css">

	<!--[if (lt IE 9) & (!IEMobile)]>
		<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>/ie.min.css">
		<script src="<?php echo $_SERVER['CWD_BASE_URI']; ?>/html5shiv.min.js"></script>
	<![endif]-->
 
</head>

<body>

	<div id="cwd-wrap">

		<div id="cwd-main">

			<aside class="navbar navbar-inverse navbar-static-top hidden-phone" id="cwd-global-nav">
				<nav class="navbar-inner"></nav>
			</aside>

			<header id="cwd-header">

				<div class="container">

					<hgroup id="cwd-hgroup">

						<h1>Orbital</h1>

					</hgroup>

					<div class="navbar">
						<div class="navbar-inner">

							<a class="btn btn-mini btn-navbar" id="cwd-menu-collapse" data-toggle="collapse" data-target=".nav-collapse">
								Menu
							</a>

							<div class="nav-collapse">

								<ul class="nav">
									<li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
									<li><a href="<?php echo site_url('tools'); ?>">Data Management Tools</a></li>
								</ul>

								<form class="navbar-form pull-right">
									<input type="search" class="search-query" placeholder="Search...">
								</form>

								<ul class="nav pull-right">
									<li><a href="#">Username</a></li>
								</ul>

							</div>
						</div>
					</div>

				</div>

			</header>




			<div class="container">
