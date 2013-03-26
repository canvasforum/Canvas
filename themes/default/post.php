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
				<?php Canvas::redirect(Canvas::getBase()); ?>
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php if(Canvas::loggedIn()): ?>
				<?php if(Poster::getType() == Poster::POST): ?>
					<?php include 'forms/post.php'; ?>
				<?php  elseif(Poster::getType() == Poster::TOPIC): ?>
					<?php include 'forms/topic.php'; ?>
				<?php elseif(Poster::getType() == Poster::EDIT): ?>
					<?php include 'forms/edit.php'; ?>
				<?php endif; ?>
			<?php else: ?>
				<h2>
					Sorry. You can't do this without being logged in. <a href="<?php echo Canvas::getBase() . 'login'; ?>">Click here</a> to log in.
				</h2>
			<?php endif; ?>
		</section>
	</body>
</html>