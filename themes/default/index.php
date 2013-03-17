<?php foreach(canvas('fetch', 'categories') as $category): ?>
	<h1><?php echo $category->name; ?></h1>
<?php endforeach; ?>