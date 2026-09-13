<?php

/**
 * Regular expression based router.
 * 
 * This class is responsible for dispatching incoming requests to the appropriate 
 * controller and action method. The router works with the incoming query string.
 * 
 * For example, if the request URL is http://localhost/base-path/user/get/3 
 * than the query string this router is going to work with is "/user/get/3"
 * @see <a href="https://www.php.net/manual/en/reserved.variables.server.php">$_SERVER</a>
 * 
 * The 'final' keyword used on methods and constants prevents child classes from 
 * overriding those methods or constants. If the class itself is being defined 
 * 'final' then it cannot be extended.
 *
 * @author Kristina Marasovic <kristina.marasovic@croatia.rit.edu>
 */
final class Router {
    /*
      // If you have different routes that need to be parsed, you usually define an array.
      private $routes = [
      "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\d+]*)\/?$/",
      "another route pattern ..."
      ];
     */

    /**
     * Regex with named capture groups to extract controller, action,
     * and parameters from the query string.
     *
     * Example: "user/edit/42" matches as:
     *   controller = "user"
     *   action     = "edit"
     *   params     = "/42"
     *
     * @var string
     */
    private $pattern = "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\d+]*)\/?$/";

    /**
     * Default controller to use if no controller is specified in the URL.
     *
     * @var string
     */
    private $controller = "UserController";

    /**
     * Default action to use if no action is specified in the URL.
     *
     * @var string
     */
    private $action = "login";

    /**
     * Parameters extracted from the URL.
     *
     * @var array<int|string>
     */
    private $params = [];

    /**
     * Dispatches the incoming request. This method parses the query string to 
     * determine the controller and action, then instantiates the controller and 
     * calls the action method with any parameters.
     * 
     * @param string $query_string The query string from the URL.
     * @throws Exception If the controller class or action method is not found.
     */
    public function dispatch($query_string) {

        if ($query_string && ($parsed = $this->parse($query_string))) {
            $this->controller = $parsed['controller'];
            $this->action = $parsed['action'];
            $this->params = $parsed['params'];
        }

        if (class_exists($this->controller)) {
            // Instantiate controller class
            $controller = new $this->controller();
            if (is_callable([$controller, $this->action])) {
                // Call the method passing params
                $controller->{$this->action}($this->params);
            } else {
                throw new Exception("Method '$this->action' in controller '$this->controller' not found");
            }
        } else {
            throw new Exception("Controller class '$this->controller' not found");
        }
    }

    /**
     * Parses the query string. Extracts the name of the controller, the action, 
     * and the parameters from the query string. The extracted values are stored 
     * as private properties of this object.
     * 
     * @param string $query_string The query string from the URL.
     * @return array|bool Returns an array with controller, action, and params if the query string matches the pattern, false otherwise.
     */
    private function parse($query_string) {
        if (preg_match($this->pattern, $query_string, $matches)) {
            $controller = ucfirst($matches["controller"]) . 'Controller'; // user --> UserController
            $action = $matches["action"];
            // 1. Remove '/' from the left side of the params string: /3/4 --> 3/4
            // 2. Split the params string using the "/" seperator: 3/4 --> ["3", "4"]
            $params = explode("/", ltrim($matches["params"], "/"));
            return [
                'controller' => $controller,
                'action' => $action,
                'params' => $params
            ];
        }
        return false;
    }
}
