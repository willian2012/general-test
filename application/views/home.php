<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>
	<h1>Mi aplicacion</h1>

	<form id="data" method="post" action="http://localhost/genera-beta/index.php/api/users/create">
		<label for="dataName">Name:</label>
		<input id="dataName" type="text" name="name" required>
		<label for="dataEmail">Email:</label>
		<input id="dataEmail" type="email" name="email" required>
		<label for="dataPassword">Password:</label>
		<input id="dataPassword" type="text" name="password" required>
		<label for="dataRole">Role:</label>
		<input id="dataRole" type="text" name="role" required>
		<input type="submit" value="Registrar">
	</form>

	<form method="get" action="http://localhost/genera-beta/index.php/api/users/2">
		<input type="submit" value="Mostrar usuarios">
	</form>
	
</body>
</html>
