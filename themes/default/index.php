<!DOCTYPE html>
<html>
	<head>
		<link href="<?php echo THEME_DIR; ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<section id="wrapper">
			<?php foreach(canvas('fetch', 'categories') as $category): ?>
				<section class="category wrap">
					<div class="innerwrap">
						<header>
							<h3><?php echo $category->name; ?></h3>
						</header>
						<?php foreach(canvas('fetch', 'forums', array('cid' => $category->id)) as $forum): ?>
							<article class="forums">
								<header>
									<a href="forum/<?php echo $forum->fid; ?>">
										<?php echo $forum->name; ?>
									</a>
								</header>
								<p>
									<?php echo $forum->description; ?>
								</p>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>
		</section>
	</body>
</html>