<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="wrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3>Register</h3>
					</header>
					<section class="bodywrap">
						<?php if(!Register::attempt() && !Canvas::loggedIn()): ?>
							<?php if(count(Canvas::getErrors())): ?>
								<aside id="errors">
									<?php foreach(Canvas::getErrors() as $error): ?>
										<span class="error"><?php echo $error; ?></span>
									<?php endforeach; ?>
								</aside>
							<?php endif; ?>
							<article class="row">
								<p>All fields are required. You will be able to customize your profile further after registering.</p>
							</article>
							<article class="row">
								<form method="POST" action="<?php echo Canvas::getURL(); ?>">
									<div>
										<label>Email Address</label>
										<input type="email" name="email" autocomplete="off" value="<?php echo Form::getInput('email'); ?>" required />
									</div>
									<div>
										<label>Username</label>
										<input type="text" name="username" autocomplete="off" value="<?php echo Form::getInput('username'); ?>" required />
									</div>
									<div>
										<label>Password</label>
										<input type="password" name="password" autocomplete="off" required />
									</div>
									<div>
										<label>Re-type Password</label>
										<input type="password" name="passwordVal" autocomplete="off" required />
									</div>
									<div>
										<label>Please Fill Out The Captcha</label>
										<img src="<?php echo Canvas::getBase('canvas') . 'captcha.php'; ?>" />
										<input type="text" name="captcha" autocomplete="off" required />
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