<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: termsAndconditions.php
 *  @Description: Terms And Condition for registering an account.
 */
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Guest Registration System</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  ––––––––––––––––––––––––––––––––––s–––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
            <h3  style="margin-top: 0%;" class="four"><?php echo Config::get('site/name'); ?></h3>
           <p style="margin-top: -2%;"><?php echo Config::get('site/slogan'); ?></p>
    <div class="row">
      
         <div class="one-half column" style=";margin-top: 4%">
             <img alt="Login" src="images/tac.jpg" style=" margin-left: -15%;float: left;"/>
      </div>
        
        
        <div class="one-half column" style="margin-top: 7%">
        <h4>Terms And Conditions</h4>
      
  <div class="row">
    <div class="twelve columns">
        <p>These terms and conditions govern your use of this website; by using this website, you accept these terms and conditions in full.   If you disagree with these terms and conditions or any part of these terms and conditions, you must not use this website. 

[You must be at least [18] years of age to use this website.  By using this website [and by agreeing to these terms and conditions] you warrant and represent that you are at least [18] years of age.]

[This website uses cookies.  By using this website and agreeing to these terms and conditions, you consent to our GRS's use of cookies in accordance with the terms of GRS's [privacy policy / cookies policy].]
</p>
        <br>
        <a class=" button button-primary" href="javascript:window.top.close();">close</a>
     
    </div>
   
  </div>
  
        
     
        
      </div>
    </div>
      <p style=" margin-top: 1%; float: right;"><?php echo Config::get('site/copy'); ?></p>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
