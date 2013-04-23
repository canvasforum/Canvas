<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if(Canvas::getForum()): ?>
				<?php echo Canvas::getForum()->getName(); ?>
			<?php else: ?>
				Forum Not Found
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<?php include 'includes/breadcrumb.php'; ?>
		<section class="wrapper">
			<?php include 'includes/notes.php'; ?>
			<?php if(Canvas::getForum()): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo Canvas::getForum()->getName(); ?></h3>
							<div id="head_buttons">
								<?php if(Canvas::loggedIn()): ?>
									<?php if(Canvas::getUser()->hasPermission(Permissions::POST_TOPICS)): ?>
										<span><a href="<?php echo Canvas::getForum()->getNewTopicURL(); ?>" title="New Topic" class="icon-pencil"></a></span>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</header>
						<section class="bodywrap">
							<?php if(count(Canvas::getForum()->getTopics())): ?>
								<?php foreach(Canvas::getForum()->getTopics() as $topic): ?>
									<article class="row">
										<div class="foruminfo">
											<header>
												<a href="<?php echo $topic->getURL(); ?>">
													<?php echo $topic->getName(); ?>
												</a>
											</header>
											<aside>
												<time>
													Started by
												 <a href="<?php echo $topic->getAuthor()->getProfileURL(); ?>"><?php echo $topic->getAuthor()->getUsername(); ?></a>
												 on <?php echo $topic->getStartDate('%B %d, %Y at %#I:%M %p'); ?>.
												</time>
											</aside>
										</div>
										<div class="forumstat">
											<span class="lastava">
												<img src="<?php echo $topic->getLastPost()->getAuthor()->getGravatar(30); ?>" />
											</span>
											<span class="lastinfo">
												<span>
													Last post by 
													<a href="<?php echo $topic->getLastPost()->getAuthor()->getURL(); ?>">
														<?php echo $topic->getLastPost()->getAuthor()->getUsername(); ?>
													</a>
												</span>
												<span>
													<?php echo relativeTime($topic->getLastPost()->getPostDate('%Y-%b-%d %#I:%M %p')); ?>
												</span>
											</span>
										</div>
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
				<?php
				new Message(Message::ERROR, 'The forum you requested could not be found.', true);
				Canvas::redirect(Canvas::getBase());
				?>
			<?php endif; ?>
		</section>
	</body>
</html>