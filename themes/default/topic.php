<?php
//Always a good idea to cache our results to save time.
$topic = Canvas::getTopic();

if($topic){
	$first = $topic->getFirstPost();
}
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
			<?php if($topic): ?>
				<section class="postwrap" id="firstpost">
					<aside class="userinfo">
						<img class="avatar" src="<?php echo $first->getAuthor()->getGravatar(90); ?>" />
						<span class="postauthor">
							<?php echo $first->getAuthor()->getUsername(); ?>
						</span>
					</aside>
					<section class="wrap">
						<div class="innerwrap">
							<header>
								<h3><?php echo $topic->getName(); ?></h3>
							</header>
							<aside class="clear postinfo">
								<span class="left">
									<time>Posted on <?php echo $first->getPostDate('%B %d, %Y at %#I:%M %p'); ?>.</time>
								</span>
								<span class="right postbuttons">
									<?php if(Canvas::loggedIn()): ?>
										<?php if($first->canEdit()): ?>
											<span>
												<a title="Edit Post" href="<?php echo $first->getEditURL(); ?>" class="icon-pencil editpost"></a>
											</span>
										<?php endif; ?>
									<?php endif; ?>
								</span>
							</aside>
							<section class="bodywrap">
								<article class="row post">
									<?php echo Markdown($first->getContents()); ?>
								</article>
								<?php if($first->isEdited()): ?>
									<aside class="row postedit">
										<time>Edited by <?php echo $first->getEditedBy()->getUsername(); ?> on <?php echo $first->getEditDate('%B %d, %Y at %#I:%M %p'); ?>.</time>
									</aside>
								<?php endif; ?>
							</section>
						</div>
					</section>
				</section>
				<?php foreach($topic->getPosts() as $post): ?>
					<section class="postwrap">
						<aside class="userinfo">
							<img class="avatar" src="<?php echo $post->getAuthor()->getGravatar(90); ?>" />
							<span class="postauthor">
								<?php echo $post->getAuthor()->getUsername(); ?>
							</span>
						</aside>
						<section class="wrap">
							<div class="innerwrap">
								<aside class="clear postinfo">
									<span class="left">
										<time>Posted on <?php echo $post->getPostDate('%B %d, %Y at %#I:%M %p'); ?>.</time>
									</span>
									<span class="right postbuttons">
										<?php if(Canvas::loggedIn()): ?>
											<?php if($post->canEdit()): ?>
												<span>
													<a title="Edit Post" href="<?php echo $post->getEditURL(); ?>" class="icon-pencil editpost"></a>
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