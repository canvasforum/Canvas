<?php if(Canvas::hasNotices()): ?>
	<aside id="notices">
		<?php foreach(Canvas::getNotices() as $notice): ?>
			<span><?php echo $notice->getMessage(); ?></span>
		<?php endforeach; ?>
	</aside>
<?php endif; ?>
<?php if(Canvas::hasErrors()): ?>
	<aside id="errors">
		<?php foreach(Canvas::getErrors() as $error): ?>
			<span><?php echo $error->getMessage(); ?></span>
		<?php endforeach; ?>
	</aside>
<?php endif; ?>