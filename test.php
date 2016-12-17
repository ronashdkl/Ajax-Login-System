<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: authenticate.php
 *  @Description: Login verify
 */

require_once 'model/user.php';
require_once 'model/userSession.php';
// require_once 'model/usermodel.php';

$users = new User();
print_r($users->all());

$users1 = new UserSession();
print_r($users1->all());

?>