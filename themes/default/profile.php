<?php
$user = Profile::getUser();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if($user): ?>
				<?php echo $user->getUsername(); ?>
			<?php else: ?>
				User Not Found
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<?php include 'includes/breadcrumb.php'; ?>
		<section class="wrapper">
			<?php if($user): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo $user->getUsername(); ?></h3>
						</header>
						<section class="bodywrap">
							<section id="profilebar">
								<article class="row">
									<img class="avatar" src="<?php echo $user->getGravatar(168); ?>" />
									<?php foreach($user->getProfile()->getFields() as $field): ?>
										<header>
											<span>
												<?php echo $field->name; ?>
											</span>
										</header>
										<p>
											<?php echo Markdown($user->getProfile()->getField($field->name)); ?>
										</p>
									<?php endforeach; ?>
								</article>
							</section>
							<section id="rightcol">
								<article id="recentactivity" class="row">
									<header>
										<span>Recent Activity</span>
									</header>
									<?php foreach($user->getPosts(15) as $post): ?>
										<span class="activity">
											<a href="<?php echo $post->getURL(); ?>">
												<?php echo Canvas::getTopic($post->getParent())->getName(); ?>
											</a>
										</span>
									<?php endforeach; ?>
								</article>
							</section>
						</section>
					</div>
				</section>
			<?php else: ?>
				<h2>Sorry. The user specified doesn't exist.</h2>
			<?php endif; ?>
		</section>
	</body>
</html>