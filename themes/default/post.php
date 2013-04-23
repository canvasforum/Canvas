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
		<?php include 'includes/breadcrumb.php'; ?>
		<section class="wrapper">
			<?php if(Canvas::loggedIn()): ?>
				<?php if(Poster::getType() == Poster::POST): ?>
					<?php include 'forms/post.php'; ?>
				<?php  elseif(Poster::getType() == Poster::TOPIC): ?>
					<?php include 'forms/topic.php'; ?>
				<?php elseif(Poster::getType() == Poster::EDIT): ?>
					<?php include 'forms/edit.php'; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php
				new Message(Message::ERROR, 'Sorry. You must be logged in to do this.', true);
				Canvas::redirect(Canvas::getBase());
				?>
			<?php endif; ?>
		</section>
	</body>
</html>