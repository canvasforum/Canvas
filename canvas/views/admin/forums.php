<?php
$uri = Canvas::getURI();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Forum Manager</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/top.php'; ?>
		<?php include 'includes/nav.php'; ?>
		<header>
			<div class="grid">
				<h2>Forum Manager</h2>
			</div>
		</header>
		<?php echo Canvas::getBase('admin'); ?>
		<div class="grid">
			<section id="main">
				<?php if($uri->length() == 2): ?>
					<?php Admin::updateForumOrder(); ?>
					<div id="categories">
						<?php foreach(Canvas::getCategories() as $category): ?>
							<article class="category" id="cat-<?php echo $category->getID(); ?>">
								<header>
									<a href="<?php echo Canvas::getURL() ?>/category/<?php echo $category->getID(); ?>">
										<h3>
											<?php echo $category->getName(); ?>
											<span class="reorder icon-reorder"></span>
										</h3>
									</a>
								</header>
								<?php foreach($category->getForums() as $forum): ?>
									<article class="forum" id="forum-<?php echo $forum->getID(); ?>">
										<a href="<?php echo Canvas::getURL() ?>/forum/<?php echo $forum->getID(); ?>">
											<?php echo $forum->getName(); ?>
											<span class="reorder icon-reorder"></span>
										</a>
									</article>
								<?php endforeach; ?>
							</article>
						<?php endforeach; ?>
					</div>
			<?php elseif($uri->length() == 4): ?>
				<?php include 'includes/forum_editor.php'; ?>
			<?php endif; ?>
			</section>
		</div>
	</body>
</html>