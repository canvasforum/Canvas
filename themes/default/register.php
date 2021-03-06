<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section class="wrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3>Register</h3>
					</header>
					<section class="bodywrap">
						<?php if(!Canvas::loggedIn() && !Register::attempt()): ?>
							<article class="row">
								<p>All fields are required. You will be able to customize your profile further after registering.</p>
							</article>
							<article class="row">
								<?php include 'includes/notes.php'; ?>
								<form method="POST" action="<?php echo Canvas::getURL(); ?>">
									<div>
										<label>Email Address</label>
										<input type="email" name="email" autocomplete="off" maxlength="255" value="<?php echo Form::getInput('email'); ?>" required />
									</div>
									<div>
										<label>Username</label>
										<input type="text" name="username" autocomplete="off" maxlength="255" value="<?php echo Form::getInput('username'); ?>" required />
									</div>
									<div>
										<label>Password</label>
										<input type="password" name="password" maxlength="255" autocomplete="off" required />
									</div>
									<div>
										<label>Confirm Password</label>
										<input type="password" name="passwordVal" maxlength="255" autocomplete="off" required />
									</div>
									<div>
										<label>Please Fill Out The Captcha</label>
										<img src="<?php echo Canvas::getBase('canvas') . 'captcha.php'; ?>" />
										<input type="text" name="captcha" maxlength="255" autocomplete="off" required />
									</div>
									<div>
										<span>
											<input type="checkbox" name="tos" required /> I agree to the terms and conditions (that don't exist yet).
										</span>
									</div>
									<div>
										<input type="submit" name="sub" value="Complete Registration" />
									</div>
								</form>
							</article>
						<?php else: Canvas::redirect(Canvas::getBase()); ?>
						<?php endif; ?>
					</section>
				</div>
			</section>
		</section>
	</body>
</html>