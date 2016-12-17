<?php

/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  
 */

class Redirect{
    public static function to($location= NULL){
        if($location){
            header('Location:' . $location);
            exit();
        }
    }

    public function hi($param) {
        
        
    }
    
        }

