<?php

/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  
 */

class Config {

    public static function get($path = NULL) {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $key) {

                if (isset($config[$key])) {

                    $config = $config[$key];
                }
            }
            return $config;
        }
        return FALSE;
    }

}
