<?php
new Message(Message::ERROR, '404 Error: The requested page was not found.', true);
Canvas::redirect(Canvas::getBase());
?>