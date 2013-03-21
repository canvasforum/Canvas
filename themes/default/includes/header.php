<header id="head">
	<div>
		<aside>
			<a href="<?php echo Canvas::getBase(); ?>">Canvas</a>
		</aside>
		<nav>
			<?php if(Canvas::loggedIn()): ?>
				<a href="<?php echo Canvas::getBase(); ?>logout">Log Out</a>
			<?php else: ?>
				<a href="<?php echo Canvas::getBase(); ?>login">Log In</a>
				<a href="<?php echo Canvas::getBase(); ?>register">Register</a>
			<?php endif; ?>			
		</nav>
	</div>
</header>