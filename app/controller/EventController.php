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

    /**
     * Displays the details of a single event.
     *
     * @return void
     */
    public function eventdetails(array $params): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $event = $this->model()->getById($params[0]);
        if($event){
            $data = ['role' => $_SESSION['role'], 'event' => $event];
            $this->view($data);
        } else{
            header('location: ' . PROJECT_URL . '/event/events');
        }
        
    }

    /**
     * Displays the list of users registered for an event.
     *
     * @param array $params The route parameters; the first one is the event id.
     * @return void
     */
    public function registered(array $params): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $event = $this->model()->getById($params[0]);

        if ($event) {
            $userModel = new UserModel();
            $data = [
                'role' => $_SESSION['role'],
                'event' => $event,
                'users' => $userModel->getByEvent($params[0]),
                'available' => $userModel->getNotRegistered($params[0])
            ];
            $this->view($data);
        } else {
            header('location: ' . PROJECT_URL . '/event/events');
            exit();
        }
    }

    /**
     * Registers the logged in user for an event.
     *
     * @param array $params The route parameters; the first one is the event id.
     * @return void
     */
    public function registerevent(array $params): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $this->model()->register($_SESSION['attendee_id'], $params[0]);
        header('location: ' . PROJECT_URL . '/event/myevents');
        exit();
    }

    /**
     * Removes the logged in user's registration for an event.
     *
     * @param array $params The route parameters; the first one is the event id.
     * @return void
     */
    public function unregisterevent(array $params): void {
        if (!isset($_SESSION['role'])) {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $this->model()->unregister($_SESSION['attendee_id'], $params[0]);
        header('location: ' . PROJECT_URL . '/event/myevents');
        exit();
    }
}