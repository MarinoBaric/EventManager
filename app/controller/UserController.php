<?php

/**
 * Description of UserController responsible for handling user-related actions.
 *
 * @extends Controller
 */
class UserController extends Controller {

    /**
     * Displays the login form.
     *
     * @return void
     */
    public function login(): void {
        $this->view();
    }

    /**
     * Processes the submitted login form. Retrieves the user data from the model 
     * and redirects the user to the page that matches their role: admins 
     * are sent to the admin page, all other users to the list of events. If no 
     * data is retrieved, redirects the user back to the home page.
     *
     * @return void
     */
    public function welcome(): void {
        $data = $this->model()->getViewModel();
        if ($data) {
            $_SESSION['attendee_id'] = $data['attendee_id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if($data['role'] === 'admin'){
                header('location: ' . PROJECT_URL . '/admin/admin');
            } else {
                header('location: ' . PROJECT_URL . '/event/events');
            }
        } else {
            header('location: ' . PROJECT_URL);
        }
    }

    /**
     * Displays the registration form.
     *
     * @return void
    */

    public function register(): void {
        $this->view();
    }

    /**
     * Saves a new user and returns to the login page.
     *
     * @return void
    */
    public function insertuser(): void {
        $ok = $this->model()->insert(
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['email'],
            $_POST['username'],
            $_POST['password']
        );

        if ($ok) {
            header('location: ' . PROJECT_URL . '/user/login');
        } else {
            header('location: ' . PROJECT_URL . '/user/register');
        }
        exit();
    }

    /**
     * Logs the user out by redirecting them to the home page.
     *
     * @return void
     */

    public function logout() : void {
        Session::destroy();
    }
}
