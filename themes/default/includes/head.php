<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/tipsy.css">
<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
<script src="<?php echo Canvas::getBase('theme'); ?>js/jquery.js"></script>
<script src="<?php echo Canvas::getBase('theme'); ?>js/jquery.expand.js"></script>
<script src="<?php echo Canvas::getBase('theme'); ?>js/tipsy.js"></script>
<script src="<?php echo Canvas::getBase('theme'); ?>js/scripting.js"></script>
<script>
var Canvas = {
	BASE: '<?php echo preg_replace('#\\' . DS . '#', '/', Canvas::getBase()); ?>'
};
</script>