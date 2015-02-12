<?php

/**
 *注销
 */
session_start();
if(session_destroy()){
    header("location:index.php");
}



?>