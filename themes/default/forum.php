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
		<section id="wrapper">
			<?php include 'includes/notes.php'; ?>
			<?php if(Canvas::getForum()): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo Canvas::getForum()->getName(); ?></h3>
							<div id="head_buttons">
								<?php if(Canvas::loggedIn()): ?>
									<?php if(Canvas::getUser()->hasPermission(Permissions::POST_TOPICS)): ?>
										<span><a href="<?php echo Canvas::getBase(); ?>post/topic/<?php echo Canvas::getForum()->getID(); ?>" title="New Topic" class="icon-pencil"></a></span>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</header>
						<section class="bodywrap">
							<?php if(count(Canvas::getForum()->getTopics())): ?>
								<?php foreach(Canvas::getForum()->getTopics() as $topic): ?>
									<article class="row">
										<header>
											<a href="<?php echo Canvas::getBase(); ?>topic/<?php echo $topic->getID(); ?>">
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