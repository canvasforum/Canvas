<?php
require 'lib/markdown.php';

if(isset($_POST['contents'])){
	echo Markdown(htmlspecialchars($_POST['contents']));
}
else{
	echo 'lel what are you doing here?';
}
?>