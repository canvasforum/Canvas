<article class="row">
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
	<form method="POST" action="<?php echo Canvas::getURL(); ?>">
		<div>
			<label>Current Password</label>
			<input type="password" name="cpassword" autocomplete="off" maxlength="255" required />
		</span>
		</div>
		<div>
			<label>New Password</label>
			<input type="password" name="npassword" autocomplete="off" maxlength="255" required />
		</div>
		<div>
			<label>Confirm New Password</label>
			<input type="password" name="cnpassword" autocomplete="off" maxlength="255" required />
		</div>
		<div>
			<span>
				<input type="submit" value="Save Changes" />
				<input type="checkbox" id="reveal" title="Having trouble typing your password?" /> Show Password
			</span>
		</div>
	</form>
</article>