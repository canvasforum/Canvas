<!DOCTYPE html>
<html>
	<head>
		<title>Canvas Forums</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<?php include 'includes/breadcrumb.php'; ?>
		<section class="wrapper">
			<?php include 'includes/notes.php'; ?>
			<?php foreach(Canvas::getCategories() as $category): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo $category->getName(); ?></h3>
						</header>
						<section class="bodywrap">
							<?php foreach($category->getForums() as $forum): ?>
								<article class="row">
									<div class="foruminfo">
										<header>
											<a href="<?php echo $forum->getURL(); ?>">
												<?php echo $forum->getName(); ?>
											</a>
										</header>
										<p>
											<?php echo $forum->getDescription(); ?>
										</p>
									</div>
									<div class="forumstat">
										<?php if($forum->hasTopics()): ?>
											<span class="lastava">
												<img src="<?php echo $forum->getLastTopic()->getLastPost()->getAuthor()->getGravatar(40); ?>" />
											</span>
											<span class="lastinfo">
												<span>
													<a href="<?php echo $forum->getLastTopic()->getLastPost()->getURL(); ?>">
														<?php echo truncate($forum->getLastTopic()->getName(), 30); ?>
													</a>
												</span>
												<span>
													By <a href="<?php echo $forum->getLastTopic()->getLastPost()->getAuthor()->getURL(); ?>">
														<?php echo $forum->getLastTopic()->getLastPost()->getAuthor()->getUsername(); ?>
													</a>
												</span>
												<span>
													<?php echo relativeTime($forum->getLastTopic()->getLastPost()->getPostDate('%Y-%b-%d %#I:%M %p')); ?>
												</span>
											</span>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</section>
					</div>
				</section>
			<?php endforeach; ?>
			<section class="wrap">
				<div class="innerwrap">
					<section class="bodywrap">
						<article class="row">
							<a href="https://github.com/canvasforum/Canvas">Help Me Build Canvas on Github!</a>
						</article>
					</section>
				</div>
			</section>
		</section>
		<section id="stats">
			<article class="wrapper">
				<span>
					<?php echo Canvas::getTotalMembers(); ?>
				</span>
				<span>Total Members</span>
				<span>
					<?php echo Canvas::getTotalPosts(); ?>
				</span>
				<span>Total Posts</span>
				<span>
					<a href="<?php echo Canvas::getNewestMember()->getURL(); ?>"><?php echo Canvas::getNewestMember()->getUsername(); ?></a>
				</span>
				<span>Is Our Newest Member</span>
			</article>
		</section>
	</body>
</html>