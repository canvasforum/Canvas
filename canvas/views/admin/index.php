<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
		<?php include 'includes/head.php'; ?>
	</head>
	<body>
		<?php include 'includes/top.php'; ?>
		<?php include 'includes/nav.php'; ?>
		<div id="split" class="grid">
			<header>
				<h2>Dashboard</h2>
			</header>
			<section id="main">
				<?php $success = Admin::updateNotepad(); ?>
				<?php if($success): ?>
					<?php new Message(Message::NOTICE, 'The admin notepad has successfully been updated.', false, Binds::ADMIN); ?>
				<?php endif; ?>
				<?php include 'includes/notes.php'; ?>
				<form id="notepad" action="<?php echo Canvas::getURL(); ?>" method="POST">
					<textarea name="adminNotepad" placeholder="Notes for yourself or your fellow admins can go here."><?php echo Settings::getSetting('adminNotepad'); ?></textarea>
					<input type="submit" value="Update Notepad" />
					<span class="progress icon-spinner icon-spin"></span>
				</form>
			</section>
			<section id="side">
				<table>
					<thead>
						<th colspan="2">Server Statistics</th>
					</thead>
					<tbody>
						<tr>
							<td class="statname">Server Type</td>
							<td><?php echo explode(' ', $_SERVER['SERVER_SOFTWARE'])[0]; ?></td>
						</tr>
						<tr>
							<td class="statname">PHP Version</td>
							<td><?php echo PHP_VERSION; ?></td>
						</tr>
						<tr>
							<td class="statname">Database Type</td>
							<td><?php echo Server::getType(); ?></td>
						</tr>
						<tr>
							<td class="statname">Database Version</td>
							<td><?php echo Server::getVersion(); ?></td>
						</tr>
					</tbody>
				</table>
				<table>
					<thead>
						<th colspan="2">Forum Statistics</th>
					</thead>
					<tbody>
						<tr>
							<td class="statname">Members</td>
							<td><?php echo Canvas::getTotalMembers(); ?></td>
						</tr>
						<tr>
							<td class="statname">Posts</td>
							<td><?php echo Canvas::getTotalPosts(); ?></td>
						</tr>
					</tbody>
				</table>
			</section>
		</div>
	</body>
</html>