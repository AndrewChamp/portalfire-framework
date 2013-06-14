<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article">
<head>
<meta charset="utf-8" />
	<title><?=htmlspecialchars_decode($core->title, ENT_QUOTES);?> |  <?=SITE_NAME;?></title>
	<link rel="icon" href="<?=THEME;?>favicon.ico" type="image/x-icon" />
	<link rel="author" href="/humans.txt" />
	<link rel="canonical" href="<?=$core->canonical();?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="robots" content="<?=str_replace(' ', ', ', $core->robots);?>" />
	<meta name="keywords" content="<?=$core->keywords;?>" />
	<meta itemprop="description" name="description" content="<?=htmlspecialchars_decode($core->description, ENT_QUOTES);?>">
	<link rel="stylesheet" href="<?=THEME;?>scripts/main.css?v=<?=CACHE_VERSION;?>" type="text/css" />
	<script async type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<!--[if lt IE 9]>
		<script>
			document.createElement('header');
			document.createElement('nav');
			document.createElement('section');
			document.createElement('article');
			document.createElement('aside');
			document.createElement('footer');
			document.createElement('hgroup');
		</script>
	<![endif]-->
	<?php
		if(!$debug->dev):
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?=GOOGLE_ANALYTICS;?>', '<?=ANALYTICS_URL;?>');
		ga('send', 'pageview');
	</script>
	<?php
		endif;
	?>
</head>
<body>

	<div id="container">
	
		<header>			
			<nav>
				<ul>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
				</ul>
			</nav>
		</header>
		
		