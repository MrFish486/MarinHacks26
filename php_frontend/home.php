<?php


session_start();

include("include/verify.php");

$mail = [];

for ($i = 0; $i < 20; $i ++) array_push($mail, ["author" => "nobody", "text" => "mesg$i"]);

?>

<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div>
			<div class="box-ne">
				<h1>Inbox - <?= count($mail) ?> messages</h1>
				<hr></hr>
				<?php if (count($mail) == 0) { ?>
					<h2>No messages.</h2>
				<?php } else { ?>
					<?php for ($i = 0; $i < count($mail); $i ++) { ?>
						<div class="message" onclick='document.getElementById("mesg_text").innerText = "<?= $mail[$i]["text"] ?>"; document.getElementById("mesg_author").innerText = "<?= $mail[$i]["author"] ?>"'>
							<h1>MESSAGE</h1>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="box-ne-right" id="mesg_pan">
				<h1>from: <a id="mesg_author"></a></h1>
				<p id="mesg_text">
				</p>
			</div>
			<div class="below-box-ne">
				<a href="/logout.php">log out</a>
			</div>
		</div>
	</body>
</html>
