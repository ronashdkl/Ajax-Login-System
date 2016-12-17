<?php

/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  
 */


class Hash{
    public static function make($string, $salt=''){
        return hash('sha256', $string . $salt);
    }
    public static function salt($size){
        return mcrypt_create_iv($size);
    }
    
    public static function unique(){
        return self::make(uniqid());
    }
}