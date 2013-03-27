<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if(Canvas::loggedIn()): ?>
				User Preferences
			<?php else: ?>
				<?php Canvas::redirect(Canvas::getBase()); ?>
			<?php endif; ?>
		</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3>User Preferences</h3>
					</header>
					<section class="bodywrap">
						<nav id="leftcol">
							<article class="row">
								<a href="<?php echo Canvas::getBase(); ?>preferences">Basic Preferences</a>
							</article>
							<article class="row">
								<a href="<?php echo Canvas::getBase(); ?>preferences/password">Change Password</a>
							</article>
							<article class="row">
								<a href="<?php echo Canvas::getBase(); ?>preferences/password">Update Profile</a>
							</article>
						</nav>
						<section id="rightcol">
							<article class="row">
								<form method="POST" action="<?php echo Canvas::getURL(); ?>">
									<div>
										<label>Name</label>
										<input type="text" name="name" />
									</span>
									</div>
									<div>
										<label>Email Address</label>
										<input type="email" name="email" required />
									</div>
									<div>
										<input type="submit" value="Save Changes" />
									</div>
								</form>
							</article>
						</section>
					</section>
				</div>
			</section>
		</section>
	</body>
</html>