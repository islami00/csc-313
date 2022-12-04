<? require 'session_helper.php'; ?>

<?php
session_start();
echo "<pre>";
var_export($_SESSION);
"</pre>";
"<pre>";

var_export($_SERVER);
"</pre>";

echo session_status();
session_reset();
session_destroy();
