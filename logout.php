<?php
session_start();
unset($_SESSION['loggedIn']);
unset($_SESSION['username']);
unset($_SESSION['role']);
session_destroy();
echo "LoggedOut";
?>