<?php
require_once 'core/init.php';
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: logout.php
 *  @Description: User logout
 */

$user = new User();
$user->logout();

    Redirect::to("index.php");

?>