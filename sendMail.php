<?php

$to = "sullirobert@gmail.com";
$subject = "new item";
$message = $_GET['message'];

mail($to, $subject, $message);

?>