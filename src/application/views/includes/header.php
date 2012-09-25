
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Common Web Design 4.0</title>
	<meta name="description" content="The Common Web Design is the new branding for the University of Lincoln's online services">
	<meta name="author" content="Online Services Team; ost@lincoln.ac.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo $_SERVER['CWD_BASE']; ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo $_SERVER['CWD_BASE']; ?>/icon.png">

	<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE']; ?>/cwd.css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet" type="text/css">

	<!--[if (lt IE 9) & (!IEMobile)]>
		<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE']; ?>/ie.min.css">
		<script src="<?php echo $_SERVER['CWD_BASE']; ?>/html5shiv.min.js"></script>
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

						<h1>Orbital Bridge</h1>

					</hgroup>

					<div class="navbar">
						<div class="navbar-inner">

							<a class="btn btn-mini btn-navbar" id="cwd-menu-collapse" data-toggle="collapse" data-target=".nav-collapse">
								Menu
							</a>

							<div class="nav-collapse">

								<ul class="nav">
									<li class="active"><a href="#">Home</a></li>
									<li><a href="#">Link</a></li>

									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											Dropdown Link
											<b class="caret"></b>
										</a>
										<ul class="dropdown-menu">
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
										</ul>
									</li>
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
