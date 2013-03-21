<header>
	<h3>New Topic</h3>
	<div id="head_buttons">
		<span id="preview">
			<a>&#xf108;</a>
		</span>
	</div>
</header>
<section class="bodywrap">
	<article class="row">
		<?php
		$success = Poster::post();
		if($success){
			Canvas::redirect(Canvas::getBase() . 'topic/' . $success);
		}
		?>
		<form method="POST" action="<?php echo Canvas::getURL(); ?>">
			<div>
				<label>Topic Name</label>
				<input type="text" name="name" value="<?php echo Form::getInput('name'); ?>" required />
			</div>
			<div>
				<label>Topic Contents: <span style="color: #33aa33;">Markdown Enabled</span></label>
				<textarea name="contents" required><?php echo Form::getInput('contents'); ?></textarea>
			</div>
			<div>
				<input type="submit" name="sub" value="Post New Topic" />
			</div>
		</form>
	</article>
</section>