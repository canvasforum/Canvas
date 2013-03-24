<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if(Poster::getType() == Poster::POST): ?>
				New Post
			<?php elseif(Poster::getType() == Poster::TOPIC): ?>
				New Topic
			<?php elseif(Poster::getType() == Poster::EDIT): ?>
				Editing Post
			<?php else: ?>
				<?php //Canvas::redirect(Canvas::getBase()); ?>
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php if(Canvas::loggedIn()): ?>
				<?php
				if(Poster::getType() == Poster::POST){
					include 'forms/post.php';
				}
				else if(Poster::getType() == Poster::TOPIC){
					include 'forms/topic.php';
				}
				else if(Poster::getType() == Poster::EDIT){
					include 'forms/edit.php';
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