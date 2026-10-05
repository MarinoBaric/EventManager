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

    /**
     * Displays the form for adding a new venue.
     *
     * @return void
     */
    public function addvenue(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $data = ['role' => $_SESSION['role']];
        $this->view($data);
    }

    /**
     * Saves a new venue and returns to the list of venues.
     *
     * @return void
     */
    public function insertvenue(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        if ($venueModel->insert($_POST['venueName'], $_POST['capacity'])) {
            header('location: ' . PROJECT_URL . '/admin/venues');
        } else {
            header('location: ' . PROJECT_URL . '/admin/addvenue');
        }
        exit();
    }

    /**
     * Displays the form for editing a venue.
     *
     * @param array $params The route parameters; the first one is the venue id.
     * @return void
     */
    public function editvenue(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        $venue = $venueModel->getById($params[0]);

        if ($venue) {
            $data = ['role' => $_SESSION['role'], 'venue' => $venue];
            $this->view($data);
        } else {
            header('location: ' . PROJECT_URL . '/admin/venues');
            exit();
        }
    }

    /**
     * Saves the submitted venue data and returns to the list of venues.
     *
     * @return void
     */
    public function updatevenue(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        $venueModel->update($_POST['venue_id'], $_POST['venueName'], $_POST['capacity']);
        header('location: ' . PROJECT_URL . '/admin/venues');
        exit();
    }

    /**
     * Deletes a venue and returns to the list of venues.
     *
     * @param array $params The route parameters; the first one is the venue id.
     * @return void
     */
    public function deletevenue(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $venueModel = new VenueModel();
        $venueModel->delete($params[0]);
        header('location: ' . PROJECT_URL . '/admin/venues');
        exit();
    }

    /**
     * Displays the list of all users.
     *
     * @return void
     */
    public function users(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $userModel = new UserModel();
        $data = ['role' => $_SESSION['role'], 'users' => $userModel->getAll()];
        $this->view($data);
    }

    /**
     * Displays the form for adding a new user.
     *
     * @return void
     */
    public function adduser(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $roleModel = new RoleModel();
        $data = ['role' => $_SESSION['role'], 'roles' => $roleModel->getAll()];
        $this->view($data);
    }

    /**
     * Saves a new user and returns to the list of users.
     *
     * @return void
     */
    public function insertuser(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $userModel = new UserModel();
        $ok = $userModel->insert(
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['email'],
            $_POST['username'],
            $_POST['password'],
            $_POST['userRole']
        );

        if ($ok) {
            header('location: ' . PROJECT_URL . '/admin/users');
        } else {
            header('location: ' . PROJECT_URL . '/admin/adduser');
        }

        exit();
    }

    /**
     * Displays the form for editing a user.
     *
     * @param array $params The route parameters; the first one is the user id.
     * @return void
     */
    public function edituser(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $userModel = new UserModel();
        $user = $userModel->getById($params[0]);

        if ($user) {
            $roleModel = new RoleModel();
            $data = [
                'role' => $_SESSION['role'],
                'user' => $user,
                'roles' => $roleModel->getAll()
            ];
            $this->view($data);
        } else {
            header('location: ' . PROJECT_URL . '/admin/users');
            exit();
        }
    }

    /**
     * Saves the submitted user data and returns to the list of users.
     *
     * @return void
     */
    public function updateuser(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $userModel = new UserModel();
        $ok = $userModel->update(
            $_POST['attendee_id'],
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['email'],
            $_POST['username'],
            $_POST['userRole']
        );

        if ($ok) {
            header('location: ' . PROJECT_URL . '/admin/users');
        } else {
            header('location: ' . PROJECT_URL . '/admin/edituser/' . $_POST['attendee_id']);
        }

        exit();
    }

    /**
     * Deletes a user and returns to the list of users.
     *
     * @param array $params The route parameters; the first one is the user id.
     * @return void
     */
    public function deleteuser(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $userModel = new UserModel();
        $userModel->delete($params[0]);
        header('location: ' . PROJECT_URL . '/admin/users');
        exit();
    }

    /**
     * Removes an attendee's registration for an event.
     *
     * @param array $params The route parameters: event id, attendee id.
     * @return void
     */
    public function removeattendee(array $params): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $eventModel->unregister($params[1], $params[0]);
        header('location: ' . PROJECT_URL . '/event/registered/' . $params[0]);
        exit();
    }

    /**
     * Registers an attendee for an event.
     *
     * @return void
     */
    public function addattendee(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('location: ' . PROJECT_URL);
            exit();
        }

        $eventModel = new EventModel();
        $eventModel->register($_POST['attendee_id'], $_POST['event_id']);
        header('location: ' . PROJECT_URL . '/event/registered/' . $_POST['event_id']);
        exit();
    }
}