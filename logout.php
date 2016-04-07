<?php
setcookie('mockauth', '', time()-3600);
header('Location: ./');
?>