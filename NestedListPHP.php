<!DOCTYPE>

<html>
<head>
	<title>NestedList</title>
	<meta name="description" content="" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/nestedList.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/NestedList.js"></script>
</head>
<body>
	<div id="pageBanner">
		<?php include('php/banner.php'); ?>
	</div>
	<div id="page">
		<div id="main">
			<div id="logo" class="floatLeft">
				<img src="images/logo.png" alt="Company Name" />
			</div>
			<div id="vLine1" class="dividerLine floatLeft"></div>	
			<div id="header" class="floatLeft">
				<h1>Project List.</h1>
			</div>
			<div id="hLine1" class="dividerLine floatLeft"></div>	
			<div id="hLine2" class="dividerLine floatLeft"></div>		
			<?php include('php/sideNav.php'); ?>
			<div id="vLine2" class="dividerLine floatLeft"></div>		
			<?php include('php/content.php'); ?>
		</div>
	</div>
	<?php include('php/footer.php'); ?>
</body>
</html>