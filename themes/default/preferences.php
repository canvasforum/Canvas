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
								<a href="<?php echo Canvas::getBase(); ?>preferences/basic">Basic Preferences</a>
							</article>
							<article class="row">
								<a href="<?php echo Canvas::getBase(); ?>preferences/password">Change Password</a>
							</article>
							<article class="row">
								<a href="<?php echo Canvas::getBase(); ?>preferences/profile">Update Profile</a>
							</article>
						</nav>
						<section id="rightcol">
							<?php if(Preferences::getType() == Preferences::BASIC): ?>
								<?php include 'forms/preferences_basic.php'; ?>
							<?php elseif(Preferences::getType() == Preferences::PASSWORD): ?>
								<?php include 'forms/preferences_pass.php'; ?>
							<?php elseif(Preferences::getType() == Preferences::PROFILE): ?>
								<?php include 'forms/preferences_profile.php'; ?>
							<?php endif; ?>
						</section>
					</section>
				</div>
			</section>
		</section>
	</body>
</html>