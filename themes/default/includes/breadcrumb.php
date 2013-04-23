<section id="bread">
	<div class="wrapper">
		<?php while(Bread::hasNext()): $item = Bread::next(); ?>
			<?php if(!$item->isActive()): ?>
				<a href="<?php echo $item->getURI(); ?>"><?php echo $item->getName(); ?></a>
			<?php else: ?>
				<span><?php echo $item->getName(); ?></span>
			<?php endif; ?>
			<?php if(Bread::hasNext()): ?>
				<span class="icon-angle-right sep"></span>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</section>