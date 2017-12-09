<!DOCTYPE html>
<html lang="en">
<head>
<title>Error</title>
<meta charset="UTF-8">
<style type="text/css">

::selection{ background-color: rgba(183, 243, 248, 1); color: rgba(255, 0, 0, 1); }
::moz-selection{ background-color: rgba(183, 243, 248, 1); color: rgba(255, 0, 0, 1); }
::webkit-selection{ background-color: rgba(183, 243, 248, 1); color: rgba(255, 0, 0, 1); }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	text-align: center;
	margin: 0 auto;
	background-color: rgba(183, 243, 248, 1);
	border: 1px solid rgba(255, 0, 0, 1);
	-webkit-box-shadow: 0 0 10px rgba(220, 0, 0, 1);
	-moz-box-shadow: 0 0 10px rgba(220, 0, 0, 1);
	box-shadow: 0 0 10px rgba(220, 0, 0, 1);
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1>קרתה בעיה רצינית, אנא תקשר עם המנהל</h1>
		<?php echo $message; ?>
	</div>
</body>
</html>