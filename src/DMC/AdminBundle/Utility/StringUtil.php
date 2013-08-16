<?php

namespace DMC\AdminBundle\Utility;

/**
 * Collection of utility methods to work with strings
 *
 * @author diego
 */
class StringUtil {
    
    /**
     * Generates a random string with the length specified by parameter
     */
    public static function generateRandomString($length = 32) {
                
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-";       
        $string = "";
        for ($i = 0; $i <= $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars)-1)];            
        }
        
        return $string;
        
    }
    
}

?>
