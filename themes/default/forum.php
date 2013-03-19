<?php
//Always a good idea to cache our results to save time.
$forum = Canvas::getForum();
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<section id="wrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3><?php echo $forum->getName(); ?></h3>
					</header>
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
				</div>
			</section>
		</section>
	</body>
</html>