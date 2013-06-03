<?php
if(!Canvas::loggedIn()) Canvas::redirect(Canvas::getBase());
?>
<link rel="stylesheet" href="<?php echo Canvas::getBase('admindep'); ?>css/normalize.css">
<link rel="stylesheet" href="<?php echo Canvas::getBase('admindep'); ?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo Canvas::getBase('admindep'); ?>css/tipsy.css">
<link href="<?php echo Canvas::getBase('admindep'); ?>css/default.css" rel="stylesheet" />
<script src="<?php echo Canvas::getBase('admindep'); ?>js/jquery.js"></script>
<script src="<?php echo Canvas::getBase('admindep'); ?>js/jquery.expand.js"></script>
<script src="<?php echo Canvas::getBase('admindep'); ?>js/tipsy.js"></script>
<script src="<?php echo Canvas::getBase('admindep'); ?>js/scripting.js"></script>
<script>
var Canvas = {
	BASE: '<?php echo preg_replace('#\\' . DS . '#', '/', Canvas::getBase()) . "admin/"; ?>'
};
</script>