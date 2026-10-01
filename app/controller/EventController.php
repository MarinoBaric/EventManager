<?php

/**
 * Description of EventController responsible for handling eventrelated actions.
 *
 * @extends Controller
 */
class EventController extends Controller {
    
    /**
     * Displays the list of all events.
     *
     * @return void
     */
    public function events(): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $data = ['role' => $_SESSION['role'], 'events' => $this->model()->getAll()];
        $this->view($data);
        
    }

    /**
     * Displays the events the current user has registered for.
     *
     * @return void
     */
    public function myevents(): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }
        
        $data = [
            'role' => $_SESSION['role'],
            'events' => $this->model()->getByAttendee($_SESSION['attendee_id'])
        ];
        $this->view($data);
    }
}
