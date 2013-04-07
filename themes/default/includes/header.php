<header id="head">
	<div>
		<aside>
			<a href="<?php echo Canvas::getBase(); ?>">Canvas</a>
		</aside>
		<nav>
			<?php if(Canvas::loggedIn()): ?>
				<div id="topdrop">
					<a href="<?php echo Canvas::getUser()->getProfileURL(); ?>">
						<img src="<?php echo Canvas::getUser()->getGravatar(16); ?>" />
						<span>
							<?php echo Canvas::getUser()->getUsername(); ?>
						</span>
					</a>
					<div id="topmenu">
						<a href="<?php echo Canvas::getBase(); ?>inbox/">Inbox 0</a>
						<a href="<?php echo Canvas::getBase(); ?>preferences/">Preferences</a>
						<a href="<?php echo Canvas::getBase(); ?>logout">Log Out</a>
					</div>
				</div>
			<?php else: ?>
				<a href="<?php echo Canvas::getBase(); ?>login">Log In</a>
				<a href="<?php echo Canvas::getBase(); ?>register">Register</a>
			<?php endif; ?>			
		</nav>
		<div class="clear"></div>
	</div>
</header>