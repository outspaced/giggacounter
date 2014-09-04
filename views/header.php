<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Giggacounter!</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			body { padding-top: 70px; }
		</style>
    	<? foreach ($scripts as $file): ?>
			<script type="text/javascript" src="<?= $file ?>"></script>
		<? endforeach ?> 
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/giggacounter">Home</a></li>
					<li><a href="http://github.com/outspaced/giggacounter">Source Code</a></li>
					<li><a href="http://www.outspaced.com">About Me</a></li>			
				</ul>
			</div>
		</nav>
	
		
		<div class="container">
