<?php

/**
 * Base class for controllers.
 * 
 * The script is loaded into Index.php, therefore, the path is relative to 
 * that file.
 *
 * @author Kristina Marasovic <kristina.marasovic@croatia.rit.edu>
 */
class Controller {

    /**
     * Starts the session and destroys it if it has expired.
     */
    public function __construct()
    {
        Session::start();

        if(Session::isExpired()){
            Session::destroy();
        }
    }

    /**
     * Loads the corresponding model for the controller.
     * 
     * @return object Returns an instance of the model associated with the controller.
     * @throws Exception If the corresponding model file doesn't exist.
     */
    public function model() {
        $model = str_replace("Controller", "Model", get_class($this));
        return new $model();
    }

    /**
     * Loads a view with optional data.
     * 
     * @param array $data Optional data to pass to the view.
     * @throws Exception If the view template file doesn't exist.
     */
    public function view($data = []) {
        $controller = strtolower(str_replace('Controller', '', get_called_class())); // UserController --> user
        $action = debug_backtrace()[1]['function']; // login OR welcome
        $viewTemplate = 'app/view/' . $controller . '/' . $action . '.php';
        if (!file_exists($viewTemplate)) {
            throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
        }

        require 'app/view/inc/header.php';
        require $viewTemplate;
        require 'app/view/inc/footer.php';
    }
}
