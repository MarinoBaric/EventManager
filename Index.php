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

    /**
     * Autoloads the class files. This method attempts to load a class file from 
     * a predefined set of directories.
     * 
     * @param string $class_name The name of the class to load.
     * @return bool Returns true if the class file was loaded, false otherwise.
     */
    private static function loadClass($class_name) {
        // Define an array of directories of classes to be loaded on request.
        $dirs = array(
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/filter/',
            'app/db/',
            'app/service/'
        );

        // Loop through each directory to load all the class files. It will only require a file once.
        // If it finds the same class in a directory later on, IT WILL IGNORE IT! Because of that require once.
        foreach ($dirs as $dir) {
            if (file_exists($dir . $class_name . '.php')) {
                require_once($dir . $class_name . '.php');
                return true;
            }
        }
        return false;
    }

    /**
     * Handles the incoming request. This method creates a new Router object and 
     * dispatches the request. The request is dispatched by providing the router 
     * with the query string used to access the page.
     * 
     * @see <a href="https://www.php.net/manual/en/reserved.variables.server.php">$_SERVER</a>
     */
    private static function handle() {

        $router = new Router();
        $router->dispatch($_SERVER["QUERY_STRING"]); // user/get/3
    }
}

// Run the application.
Index::run();
