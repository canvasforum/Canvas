<?php if(Canvas::getUser()->hasPermission(Permissions::POST_REPLIES)): ?>
	<section class="wrap">
		<div class="innerwrap">
			<header>
				<h3>Post Reply</h3>
				<div id="head_buttons">
					<span id="preview">
						<a title="Preview Post" class="icon-desktop"></a>
					</span>
				</div>
			</header>
			<section class="bodywrap">
				<article class="row" id="preview_post"></article>
				<article class="row">
					<?php $success = Poster::post(); ?>
					<?php if($success): ?>
						<?php Canvas::redirect(Canvas::getBase() . 'topic/' . Poster::getTopic()->getID() . '#' . $success); ?>
					<?php elseif(Canvas::hasErrors(Binds::POST_FORM)): ?>
						<aside id="errors">
							<?php foreach(Canvas::getErrors(Binds::POST_FORM) as $error): ?>
								<span class="error"><?php echo $error->getMessage(); ?></span>
							<?php endforeach; ?>
						</aside>
					<?php endif; ?>
					<form method="POST" action="<?php echo Canvas::getBase(); ?>post/post/<?php echo Canvas::getID(); ?>">
						<div>
							<textarea name="contents" required><?php echo Form::getInput('contents'); ?></textarea>
						</div>
						<div class="clear">
							<span class="left">
								<input type="submit" name="sub" value="Post New Reply" />
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
	new Message(Message::ERROR, 'Sorry. You don\'t have permission to reply to this topic.', true);
	Canvas::redirect(Canvas::getBase());
	?>
<?php endif; ?>