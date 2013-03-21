<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<?php foreach(Canvas::getCategories() as $category): ?>
				<section class="wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo $category->getName(); ?></h3>
						</header>
						<section class="bodywrap">
							<?php foreach($category->getForums() as $forum): ?>
								<article class="row">
									<div>
										<header>
											<a href="<?php echo Canvas::getBase(); ?>forum/<?php echo $forum->getID(); ?>">
												<?php echo $forum->getName(); ?>
											</a>
										</header>
										<p>
											<?php echo $forum->getDescription(); ?>
										</p>
									</div>
								</article>
							<?php endforeach; ?>
						</section>
					</div>
				</section>
			<?php endforeach; ?>
		</section>
	</body>
</html>