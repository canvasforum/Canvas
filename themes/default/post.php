<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if(Poster::getType() == 'post'): ?>
				New Post
			<?php else: ?>
				New Topic
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php if(Canvas::loggedIn()): ?>
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
			<?php else: ?>
				<h2>
					Sorry. You can't post without being logged in. <a href="<?php echo Canvas::getBase() . 'login'; ?>">Click here</a> to log in.
				</h2>
			<?php endif; ?>
		</section>
	</body>
</html>