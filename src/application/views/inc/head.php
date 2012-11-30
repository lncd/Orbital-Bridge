
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php if(isset($title)) echo $title . ' - '; ?>Orbital</title>
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
	
	<script type="text/javascript">
	
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-27617986-2']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	
	</script>
 
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
									<li<?php if($page === 'home') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> Home</a></li>
									
									<?php
									foreach($categories as $category)
									{
									?>
									<li class="dropdown<?php if($page === $category->title) echo ' active'; ?>">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo $category->title; ?> <b class="caret"></b></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
										<?php
										foreach($category_pages[$category->id] as $page)
										{
											echo'<li'; ?>><a href="<?php echo $page->slug; ?>"> <?php echo $page->title; ?></a></li><?php
										}
										?>
										</ul>
									</li>
																	
									
									<?php	
									}
									?>

									<li<?php if($page === 'contact') echo ' class="active"'; ?>><a href="<?php echo site_url('contact'); ?>"><i class="icon-bullhorn"></i> Contact</a></li>
								</ul>
							</div>
							
							<div class="nav-collapse pull-right">
								<ul class="nav">

								<?php if ($this->session->userdata('access_token')): ?>
								
									<li class="dropdown<?php if($page === 'me') echo ' active'; ?>">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <?php echo $this->session->userdata('user_name'); ?> <b class="caret"></b></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<li><a href="<?php echo site_url('me'); ?>"><i class="icon-list"></i> My Projects</a></li>
											<li><a href="<?php echo site_url('me'); ?>"><i class="icon-user"></i> My Profile</a></li>
											<?php if ($this->session->userdata('user_admin')): ?>
										<li<?php if($page === 'admin') echo ' class="active"'; ?>><a href="<?php echo site_url('admin'); ?>"><i class="icon-cogs"></i> Site Admin</a></li>
										<?php endif; ?>
											<li><a href="<?php echo site_url('signout'); ?>"><i class="icon-signout"></i> Sign Out</a></li>
										</ul>
									</li>
								
								<?php else: ?>
								
									<li><a href="<?php echo site_url('signin'); ?>"><i class="icon-signin"></i> Sign In</a></li>
								
								<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>

				</div>

			</header>




			<div class="container">
