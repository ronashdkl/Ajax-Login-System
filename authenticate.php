<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: authenticate.php
 *  @Description: Login verify
 */
require_once 'core/init.php';
$user = new User();
if ($user->isLoggedIn()) {
    Redirect::to("profile.php");
}

	if(isset($_POST['send'])){

		$arr= array();

		if($_POST['credential'] == 'mono'){
			//$_SESSION['logged_in'] = true;
			
			  $login = $user->login("ronash", "Lokesh4u", FALSE);
            if ($login) {
             $arr['success'] = true;
            } else {
              $arr['success'] = false;
            }
		} else {
			$arr['success'] = false;
		}

		echo json_encode($arr);
	}

  
   
    

?>