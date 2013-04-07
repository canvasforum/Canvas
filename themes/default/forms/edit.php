<?php if(Poster::getPost()->canEdit()): ?>
	<section class="wrap">
		<div class="innerwrap">
			<header>
				<h3>Editing Post</h3>
				<div id="head_buttons">
					<span id="preview">
						<a title="Preview Post" class="icon-desktop"></a>
					</span>
				</div>
			</header>
			<section class="bodywrap">
				<article class="row" id="preview_post"></article>
				<article class="row">
					<?php if(Poster::post()): ?>
						<?php Canvas::redirect(Canvas::getBase() . 'topic/' . Poster::getTopic()->getID() . '#' . Poster::getPost()->getID()); ?>
					<?php elseif(Canvas::hasErrors()): ?>
						<aside id="errors">
							<?php foreach(Canvas::getErrors() as $error): ?>
								<span class="error"><?php echo $error; ?></span>
							<?php endforeach; ?>
						</aside>
					<?php endif; ?>
					<form method="POST" action="<?php echo Canvas::getURL(); ?>">
						<?php if(Poster::getPost()->isFirstPost()): ?>
							<div>
								<label>Topic Name</label>
								<input type="text" name="name" value="<?php echo Poster::getTopic()->getName(); ?>" required />
							</div>
						<?php endif; ?>
						<div>
							<label>Contents</label>
							<textarea name="contents" required><?php echo Poster::getPost()->getRaw(); ?></textarea>
						</div>
						<div class="clear">
							<span class="left">
								<input type="submit" name="sub" value="Finish Editing Post" />
							</span>
							<span class="right">
								Feel free to use <a href="http://daringfireball.net/projects/markdown/syntax">Markdown</a> in your posts.
							</span>
						</div>
					</form>
				</article>
			</section>
		</div>
	</section>
<?php else: ?>
	<?php
	new Message(Message::ERROR, 'The forum you requested could not be found.', true);
	Canvas::redirect(Canvas::getBase());
	?>
<?php endif; ?>