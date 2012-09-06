<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=nombre.doc");
header("Pragma: no-cache");
header("Expires: 0");

echo $_POST['datos_a_enviar'];
?>