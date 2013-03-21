<?php
//Always a good idea to cache our results to save time.
$forum = Canvas::getForum();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $forum->getName(); ?></title>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3><?php echo $forum->getName(); ?></h3>
						<div id="head_buttons">
							<span><a href="<?php echo Canvas::getBase(); ?>post/topic/<?php echo $forum->getID(); ?>">&#xf040;</a></span>
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
		</section>
	</body>
</html>