<?php
session_start();
session_destroy();
header('Location: ../connection_page.html');
exit();
?>