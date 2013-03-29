<?php
//Always a good idea to cache our results to save time.
$topic = Canvas::getTopic();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if($topic): ?>
				<?php echo $topic->getName(); ?>
			<?php else: ?>
				Topic Not Found
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php include 'includes/notes.php'; ?>
			<?php if($topic): ?>
				<?php foreach($topic->getPosts() as $post): ?>
					<section class="postwrap" id="<?php echo $post->getID(); ?>">
						<aside class="userinfo">
							<img class="avatar" src="<?php echo $post->getAuthor()->getGravatar(90); ?>" />
							<span class="postauthor">
								<?php echo $post->getAuthor()->getUsername(); ?>
							</span>
						</aside>
						<section class="wrap">
							<div class="innerwrap">
								<?php if($post->isFirstPost()): ?>
									<header>
										<h3><?php echo $topic->getName(); ?></h3>
									</header>
								<?php endif; ?>
								<aside class="clear postinfo">
									<span class="left">
										<time>Posted on <?php echo $post->getPostDate('%B %d, %Y at %#I:%M %p'); ?>.</time>
									</span>
									<span class="right postbuttons">
										<?php if(Canvas::loggedIn()): ?>
											<?php if($post->canEdit()): ?>
												<span>
													<a title="Edit Post" href="<?php echo $post->getEditURL(); ?>" class="icon-pencil"></a>
												</span>
											<?php endif; ?>
											<?php if($post->canDelete()): ?>
												<span>
													<a title="Delete Post" href="<?php echo $post->getDeleteURL(); ?>" class="icon-remove"></a>
												</span>
											<?php endif; ?>
										<?php endif; ?>
									</span>
								</aside>
								<section class="bodywrap">
									<article class="row post">
										<?php echo Markdown($post->getContents()); ?>
									</article>
									<?php if($post->isEdited()): ?>
									<aside class="row postedit">
											<time>Edited by <?php echo $post->getEditedBy()->getUsername(); ?> on <?php echo $post->getEditDate('%B %d, %Y at %#I:%M %p'); ?>.</time>
										</aside>
									<?php endif; ?>
								</section>
							</div>
						</section>
					</section>
				<?php endforeach; ?>
				<?php if(Canvas::loggedIn() && Canvas::getUser()->hasPermission(Permissions::POST_REPLIES)): ?>
					<?php include 'forms/post.php'; ?>
				<?php endif; ?>
			<?php else: ?>
				<h2>
					Sorry. The topic you requested could not be found.
				</h2>
			<?php endif; ?>
		</section>
	</body>
</html>