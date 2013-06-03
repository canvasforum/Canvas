<?php if(Canvas::hasNotices(Binds::ADMIN)): ?>
	<aside id="notices">
		<?php foreach(Canvas::getNotices(Binds::ADMIN) as $notice): ?>
			<span><?php echo $notice->getMessage(); ?></span>
		<?php endforeach; ?>
	</aside>
<?php endif; ?>
<?php if(Canvas::hasErrors(Binds::ADMIN)): ?>
	<aside id="errors">
		<?php foreach(Canvas::getErrors(Binds::ADMIN) as $error): ?>
			<span><?php echo $error->getMessage(); ?></span>
		<?php endforeach; ?>
	</aside>
<?php endif; ?>