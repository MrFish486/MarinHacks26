<?php


session_start();

include("include/verify.php");

include("include/adbook.php");

$mail = [];

$file_content = file_get_contents("../data/record.json");
$mail = json_decode($file_content, true)["msg"];


?>

<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div>
			<div class="box-ne">
				<h1>Inbox - <?= count($mail) ?> message<?= count($mail) != 1 ? "s" : "" ?></h1>
				<hr></hr>
				<a href="compose.php">compose message</a>
				<hr></hr>
				<?php if (count($mail) == 0) { ?>
					<h2>No messages.</h2>
				<?php } else { ?>
					<?php for ($i = 0; $i < count($mail); $i ++) { ?>
						<div class="message" onclick='document.getElementById("mesg_text").innerText = "<?= $mail[$i]["text"] ?>"; document.getElementById("mesg_author").innerText = "from: <?= adbook_lookup($mail[$i]["author"]) ?>"; document.getElementById("mesg_menu").classList.remove("hidden"); document.getElementById("mesg_delete").href=`delete.php?i=<?= $i ?>`'>
							<h3>message from <?= htmlspecialchars(adbook_lookup($mail[$i]["author"])) ?></h3>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="box-ne-right" id="mesg_pan">
				<h3><a id="mesg_author">select a message</a></h3>
				<div class="hidden fb" id="mesg_menu">
					<hr></hr>
					<p id="mesg_text"></p>
					<hr></hr>
					<a id="mesg_delete" href="delete.php?i=<?= $i ?>">delete</a>
				</div>
			</div>
			<div class="below-box-ne">
				<a href="/logout.php">log out</a>
			</div>
		</div>
	</body>
</html>
