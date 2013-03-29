<?php if(!Preferences::attempt()): ?>
	<?php if(Canvas::hasErrors()): ?>
		<aside id="errors">
			<?php foreach(Canvas::getErrors() as $error): ?>
				<span class="error"><?php echo $error->getMessage(); ?></span>
			<?php endforeach; ?>
		</aside>
	<?php endif; ?>
<?php else: ?>
	<?php if(Canvas::hasNotices()): ?>
		<aside id="notices">
			<?php foreach(Canvas::getNotices() as $notice): ?>
				<span class="error"><?php echo $notice->getMessage(); ?></span>
			<?php endforeach; ?>
		</aside>
	<?php endif; ?>
<?php endif; ?>
<article class="row">
	<form method="POST" action="<?php echo Canvas::getURL(); ?>">
		<div>
			<label>Name</label>
			<input type="text" name="name" value="<?php echo Canvas::getUser()->getName(); ?>"/>
		</span>
		</div>
		<div>
			<label>Email Address</label>
			<input type="email" name="email" value="<?php echo Canvas::getUser()->getEmail(); ?>" required />
		</div>
		<div>
			<label>Location</label>
			<?php echo Preferences::buildTimeSelect(); ?>
		</div>
		<div>
			<input type="submit" value="Save Changes" />
		</div>
	</form>
</article>