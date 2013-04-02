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
		<?php foreach(Profile::getFields() as $field): ?>
			<div>
				<label>
					<?php echo $field->label; ?>
				</label>
				<?php if($field->type == 'varchar'): ?>
					<input type="text" name="<?php echo $field->name; ?>" value="<?php echo Canvas::getUser()->getProfile()->getField($field->name); ?>" maxlength="255" />
				<?php else: ?>
					<textarea name="<?php echo $field->name; ?>"><?php echo Canvas::getUser()->getProfile()->getField($field->name); ?></textarea>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<div>
			<input type="submit" value="Save Changes" />
		</div>
	</form>
</article>