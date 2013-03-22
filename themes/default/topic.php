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
							<section class="bodywrap">
								<article class="row post">
									<?php echo Markdown($first->getContents()); ?>
								</article>
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
								<section class="bodywrap">
									<article class="row post">
										<?php echo Markdown($post->getContents()); ?>
									</article>
								</section>
							</div>
						</section>
					</section>
				<?php endforeach; ?>
				<?php if(Canvas::loggedIn()): ?>
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