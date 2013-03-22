<?php
require 'lib/Markdown.php';

if(isset($_POST['contents'])){
	echo Markdown(htmlspecialchars($_POST['contents']));
}
else{
	echo 'lel';
}
?>