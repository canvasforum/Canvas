<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php if(Canvas::loggedIn()): ?>
				<section class="wrap">
					<div class="innerwrap">
						<?php
						if(Poster::getType() == 'post'){
							include 'forms/post.php';
						}
						else if(Poster::getType() == 'topic'){
							include 'forms/topic.php';
						}
						else{
							echo 'Invalid arguments specified.';
						}
						?>
					</div>
				</section>
			<?php else: ?>
				<h2>
					Sorry. You can't post without being logged in. <a href="<?php echo Canvas::getBase() . 'login'; ?>">Click here</a> to log in.
				</h2>
			<?php endif; ?>
		</section>
	</body>
</html>