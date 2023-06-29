<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>

<h1><?php echo $title; ?></h1>

<form id="data" method="post" action="http://localhost/genera-beta/index.php/api/users/create">
	<label for="dataName">Name:</label>
	<input id="dataName" type="text" name="name">
	<label for="dataPhone">Tellphone:</label>
	<input id="dataPhone" type="text" name="tellphone">
	<label for="dataEmail">Email:</label>
	<input id="dataEmail" type="email" name="email">
	<input type="submit" value="Registrar">
</form>

<a href="<?= base_url('download-file/' . $file['id']) ?>">Descargar archivo</a>
</body>
</html>
