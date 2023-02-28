<?php
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?activity=log-out_successful');
?>