<link rel="stylesheet" href="<?php echo Canvas::getBase('theme'); ?>css/font-awesome.min.css">
<link href="<?php echo Canvas::getBase('theme'); ?>css/default.css" rel="stylesheet" />
<script src="<?php echo Canvas::getBase('theme'); ?>js/jquery.js"></script>
<script src="<?php echo Canvas::getBase('theme'); ?>js/scripting.js"></script>
<script>
var Canvas = {
	BASE: '<?php echo preg_replace('#\\' . DS . '#', '/', Canvas::getBase()); ?>'
};
</script>