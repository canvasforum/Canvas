<?php
//Always a good idea to cache our results to save time.
$forum = Canvas::getForum();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if($forum): ?>
				<?php echo $forum->getName(); ?>
			<?php else: ?>
				Forum Not Found
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php if($forum): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo $forum->getName(); ?></h3>
							<div id="head_buttons">
								<?php if(Canvas::getUser()->hasPermission(Permissions::POST_TOPICS)): ?>
									<span><a href="<?php echo Canvas::getBase(); ?>post/topic/<?php echo $forum->getID(); ?>" title="New Topic">&#xf040;</a></span>
								<?php endif; ?>
							</div>
						</header>
						<section class="bodywrap">
							<?php if(count($forum->getTopics())): ?>
								<?php foreach($forum->getTopics() as $topic): ?>
									<article class="row">
										<header>
											<a href="<?php echo Canvas::getBase(); ?>topic/<?php echo $topic->getID(); ?>">
												<?php echo $topic->getName(); ?>
											</a>
										</header>
										<aside>
											<span>Started by <?php echo $topic->getAuthor()->getUsername(); ?> on <?php echo $topic->getStartDate('%B %d, %Y at %#I:%M %p'); ?>.</span>
										</aside>
									</article>
								<?php endforeach; ?>
							<?php else: ?>
								<article class="row">
									<p>This forum currently has no topics. Why don't you start one?</p>
								</article>
							<?php endif; ?>
						</section>
					</div>
				</section>
			<?php else: ?>
				<h2>
					Sorry. The forum you requested could not be found.
				</h2>
			<?php endif; ?>
		</section>
	</body>
</html>