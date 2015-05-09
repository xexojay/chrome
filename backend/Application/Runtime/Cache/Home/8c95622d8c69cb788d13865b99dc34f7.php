<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>login</title>
</head>
<body>
  <form action="/index.php/ceshi/login_check" method="post">
  	name:<input type="text" name="name">
  	<br>
  	pwd:<input type="password" name="password">
  	<br>
  	submit:<button type="submit">Submit</button>
  </form>
</body>
</html>