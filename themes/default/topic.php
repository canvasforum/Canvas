<?php
//Always a good idea to cache our results to save time.
$topic = Canvas::getTopic();
$first = $topic->getFirstPost();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $topic->getName(); ?></title>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
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
			<?php foreach($topic->getPosts() as $post): ?>
				<section class="wrap">
					<div class="innerwrap">
						<section class="bodywrap">
							<article class="row post">
								<?php echo Markdown($post->getContents()); ?>
							</article>
						</section>
					</div>
				</section>
			<?php endforeach; ?>
		</section>
	</body>
</html>