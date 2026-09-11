<?php

/**
 * Final class Index.
 * 
 * This class serves as the entry point for the MVC application. It initializes 
 * the application, sets up the autoloader, and handles incoming requests.
 * 
 * The 'final' keyword used on methods and constants  prevents child classes from 
 * overriding those methods or constants. If the class itself is being defined 
 * 'final' then it cannot be extended.
 * 
 * @author Kristina Marasovic <kristina.marasovic@croatia.rit.edu>
 */
final class Index {

    /**
     * Runs the application. This method initializes the application and 
     * starts handling the incoming request by using the Router.
     */
    public static function run() {
        self::init();
        self::handle();
    }

    /**
     * Initializes the application. This method sets the error reporting level, 
     * registers the autoloader, and defines constants for the rest of the framework
     * to use.
     */
    private static function init() {
        // Report all errors (ensure you have display_errors = On in your php.ini file)
        // and make PHP suggest changes to your code for the best interoperability.
        // error_reporting(E_ALL | E_STRICT);
                
        // Report fatal run-time errors. These indicate errors that can not be 
        // recovered from, such as a memory allocation problem. Execution of the script is halted.
        // Also, make PHP suggest changes to your code for the best interoperability.

        
        error_reporting(E_ERROR);

        // Define constants
        define('CONFIG_DATA', parse_ini_file('./app/config/config.ini', true));
        define('PROJECT_URL', CONFIG_DATA['app']['project_url']);        
        define('TITLE', 'MVC with OO PHP');

        // Register the aoutoloader.
        spl_autoload_register(['Index', 'loadClass']);        
        
    }
}
