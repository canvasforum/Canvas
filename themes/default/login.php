<!DOCTYPE html>
<html>
	<head>
		<title>Log In</title>
		<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
		<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<section id="loginwrapper">
			<section class="wrap">
				<div class="innerwrap">
					<header>
						<h3>Log In</h3>
					</header>
					<section class="bodywrap">
						<?php if(!Login::attempt() && !Canvas::loggedIn()): ?>
							<article class="row">
								<?php if(Canvas::hasErrors()): ?>
									<aside id="errors">
										<?php foreach(Canvas::getErrors() as $error): ?>
											<span class="error"><?php echo $error->getMessage(); ?></span>
										<?php endforeach; ?>
									</aside>
								<?php endif; ?>
								<form method="POST" action="<?php echo Canvas::getURL(); ?>">
									<div>
										<label>Username or Email</label>
										<input type="text" name="handle" autocomplete="off" value="<?php echo Form::getInput('handle'); ?>" required />
									</div>
									<div>
										<label>Password <a href="<?php echo Canvas::getBase(); ?>forgot">(Forgot your password?)</a></label>
										<input type="password" name="password" autocomplete="off" required />
									</div>
									<div>
										<div>
											<span>
												<input type="submit" name="sub" value="Log In" />
												<input type="checkbox" name="remember" /> Remember Me
											</span>
											<span>
												<a href="<?php echo Canvas::getBase(); ?>register">Need an account?</a>
											</span>
										</div>
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