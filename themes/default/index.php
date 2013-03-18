<?php foreach(canvas('fetch', 'categories') as $category): ?>
	<h1><?php echo $category->name; ?></h1>
	<?php foreach(canvas('fetch', 'forums', array('cid' => $category->id)) as $forum): ?>
		<a href="forum/<?php echo $forum->fid; ?>">
			<?php echo $forum->name; ?>
		</a>
	<?php endforeach; ?>
<?php endforeach; ?>