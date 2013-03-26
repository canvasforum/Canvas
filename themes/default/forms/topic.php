<?php if(Canvas::getUser()->hasPermission(Permissions::POST_TOPICS)): ?>
	<section class="wrap">
		<div class="innerwrap">
			<header>
				<h3>New Topic</h3>
				<div id="head_buttons">
					<span id="preview">
						<a title="Preview Post">&#xf108;</a>
					</span>
				</div>
			</header>
			<?php $success = Poster::post(); ?>
			<?php if($success): ?>
				<?php Canvas::redirect(Canvas::getBase() . 'topic/' . $success); ?>
			<?php elseif(Canvas::hasErrors()): ?>
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
							<label>Topic Name</label>
							<input type="text" name="name" value="<?php echo Form::getInput('name'); ?>" required />
						</div>
						<div>
							<label>Topic Contents</label>
							<textarea name="contents" required><?php echo Form::getInput('contents'); ?></textarea>
						</div>
						<div class="clear">
							<span class="left">
								<input type="submit" name="sub" value="Post New Topic" />
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
	<h2>
		Sorry. You don't have permission to post a new topic.
	</h2>
<?php endif; ?>