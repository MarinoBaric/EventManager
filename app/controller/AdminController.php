<?php

/**
 * Description of AdminController responsible for handling administrative actions.
 *
 * @extends Controller
 */
class AdminController extends Controller {

    /**
     * Displays the admin page with the list of events that can be managed.
     *
     * @return void
     */
    public function admin(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $data = ['role' => $_SESSION['role'], 'events' => $eventModel->getAll()];
        $this->view($data);
    }
}
