<?php

session_start();

include("include/verify.php");

include("include/adbook.php");

?>

<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div>
			<div class="box-ne">
				<h1>Address book</h1>
				<hr></hr>
				<?php foreach (adbook_list() as $a => $b) { ?>
					<textarea><?= $a ?></textarea><br><br>
					<input value="<?= $b ?>"></input>
					<hr>
				<?php } ?>
			</div>
			<div class="below-box-ne">
				<a href="/logout.php">log out</a>
				<a href="/home.php">home</a>
			</div>
		</div>
	</body>
</html>
