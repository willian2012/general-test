<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>

	<h1><?php echo "registrado!"; ?></h1>
	<form method="get" action="http://localhost/genera-beta/index.php/api/users/create">
		<input type="submit" value="Mostrar usuarios">
	</form>
	<?php 
		 foreach ($results as $row): ?>
			<table border="1">
				<thead>
					<th>ID: </th>
					<td>Name</td>
					<td>Tellphone</td>
					<td>Email</td>
					<td>Delete</td>
				</thead>
				<tbody>
					<td><?php echo $row['ID']?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['tellphone']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><form method="post" action="http://localhost/codeigniter/index.php/data/selectData">
							<input type="number" value="<?php echo $row['ID']; ?>" hidden>
							<button type="submit"> X </button>
						</form>
					</td>
				</tbody>
			</table>
			<?php endforeach;  ?>
</body>
</html>