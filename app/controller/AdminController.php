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

    /**
     * Displays the form for editing an event.
     *
     * @param array $params The route parameters; the first one is the event id.
     * @return void
     */
    public function editevent(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $event = $eventModel->getById($params[0]);

        if ($event) {
            $venueModel = new VenueModel();
            $data = [
                'role' => $_SESSION['role'],
                'event' => $event,
                'venues' => $venueModel->getAll()
            ];
            $this->view($data);
        } else {
            header('location: ' . PROJECT_URL . '/admin/admin');
        }
    }

    /**
     * Deletes an event and returns to the admin page.
     *
     * @param array $params The route parameters; the first one is the event id.
     * @return void
    */
    public function deleteevent(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $eventModel->delete($params[0]);
        header('location: ' . PROJECT_URL . '/admin/admin');
    }


    /**
     * Saves the submitted event data and returns to the admin page.
     *
     * @return void
    */
    public function updateevent(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $ok = $eventModel->update(
            $_POST['event_id'],
            $_POST['eventName'],
            $_POST['startDate'],
            $_POST['endDate'],
            $_POST['allowedNumber'],
            $_POST['venue']
        );

        if ($ok) {
            header('location: ' . PROJECT_URL . '/admin/admin');
        } else {
            header('location: ' . PROJECT_URL . '/admin/editevent/' . $_POST['event_id']);
        }

        exit();
    }

    /**
     * Displays the form for adding a new event.
     *
     * @return void
    */
    public function addevent(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        $data = ['role' => $_SESSION['role'], 'venues' => $venueModel->getAll()];
        $this->view($data);
    }

    /**
     * Saves a new event and returns to the admin page.
     *
     * @return void
    */
    public function insertevent(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $ok = $eventModel->insert(
            $_POST['eventName'],
            $_POST['startDate'],
            $_POST['endDate'],
            $_POST['allowedNumber'],
            $_POST['venue']
        );

        if ($ok) {
            header('location: ' . PROJECT_URL . '/admin/admin');
        } else {
            header('location: ' . PROJECT_URL . '/admin/addevent');
        }

        exit();
    }

    /**
     * Displays the list of all venues.
     *
     * @return void
     */
    public function venues(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        $data = ['role' => $_SESSION['role'], 'venues' => $venueModel->getAll()];
        $this->view($data);
    }
}
