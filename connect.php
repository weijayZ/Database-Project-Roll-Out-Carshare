<?php
$connection = mysqli_connect('localhost', 'TonyHawk', 'SkateBoard');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'rollout');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>
