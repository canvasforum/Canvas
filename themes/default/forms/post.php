<section class="wrap">
	<div class="innerwrap">
		<header>
			<h3>Post Reply</h3>
				<div id="head_buttons">
				<span id="preview">
					<a>&#xf108;</a>
				</span>
			</div>
		</header>
		<?php $success = Poster::post(); ?>
		<?php if($success): ?>
			<?php Canvas::redirect(Canvas::getBase() . 'topic/' . $success); ?>
		<?php elseif(count(Canvas::getErrors())): ?>
			<aside id="errors">
				<?php foreach(Canvas::getErrors() as $error): ?>
					<span class="error"><?php echo $error; ?></span>
				<?php endforeach; ?>
			</aside>
		<?php endif; ?>
		<section class="bodywrap">
			<article class="row" id="preview_post"></article>
			<article class="row">
				<form method="POST" action="<?php echo Canvas::getURL(); ?>">
					<div>
						<label>Topic Contents: <span style="color: #33aa33;">Markdown Enabled</span></label>
						<textarea name="contents" required></textarea>
					</div>
					<div>
						<input type="submit" name="sub" value="Post New Reply" />
					</div>
				</form>
			</article>
		</section>
	</div>
</section>