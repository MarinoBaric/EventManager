<?php

/**
 * Description of User. 
 * 
 * In an object-oriented MVC (Model-View-Controller) based PHP application, 
 * validation rules are typically stored in the model (if not in a DB). Each 
 * model class, which represents an entity (e.g., User, Product, Order), can 
 * contain its own set of validation rules. This encapsulates the rules within 
 * the context of the specific data they pertain to, ensuring that the business 
 * logic is cleanly separated from other layers like the controller or view.
 * 
 * The UserModel class extends the Model class. It holds the validation rules 
 * for user input and retrieves registered users from the database, together 
 * with the name of their role. Passwords are stored as hashes and verified 
 * with password_verify().
 *
 */
class UserModel extends Model {

    /**
     * Validation rules for user input. This array contains the validation rules 
     * for the fields in the UserModel. Each key represents a field name and the 
     * value is an array of rules to validate that field.
     * 
     * @var array
     */
    private $validationRules = [
        'first_name' => [
            'required' => true,
            'max_length' => 45
        ],
        'last_name' => [
            'required' => true,
            'max_length' => 45
        ],
        'username' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 16,
            'regex' => "/^[a-zA-Z0-9_]+$/"
        ],
        'password' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 20
        ],
        'email' => [
            'required' => true,
            'max_length' => 50
        ],
        'role' => [
            'required' => true
        ]
    ];

    

    private $attendee_id;
    private $first_name;
    private $last_name;
    private $email;
    private $username;
    private $password;
    private $role_name;

    public function getAttendeeId() {
        return $this->attendee_id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoleName() {
        return $this->role_name;
    }

    /**
     * Retrieves the user information after sanitizing and validating the input.
     * 
     * This method is responsible for processing user input (username and password)
     * from the form, sanitizing the inputs to ensure they are safe, and then validating 
     * the data against the predefined rules in the `$validationRules` array. 
     * If the sanitized input data is valid and the user is registered, the method 
     * returns an associative array containing the username and the user's email and their role.
     * If validation fails or the credentials are incorrect, it returns `false` or `null` 
     * respectively.
     * 
     * @return array|null|bool Returns an array with `username`, `email` and `role` 
     * if credentials are correct, `false` if validation fails, or `null` if the 
     * credentials do not match.
     */
    public function getViewModel() {

        // Input data that needs to be sanitized and validated.
        $input = [
            'username' => $_POST['username'],
            'password' => $_POST['password']
        ];

        // 1. Sanitize input data
        $input = $this->sanitize($input);
        
        // 2. Validate input data
        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        // 3. Check if username and password matches AND only then return the view model.


        $user = $this->getByUsername($input['username']);

        if ($user && password_verify($input['password'], $user->getPassword())) {
            return [
                'attendee_id' => $user->getAttendeeId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'role' => $user->getRoleName()
            ];
        }

        return null;
    }

    /**
     * Retrieves a user by username, including the name of their role.
     *
     * @param string $username The username to look for.
     * @return object|false The UserModel object if found, false otherwise.
    */
    public function getByUsername(string $username): object|false {
        return $this->queryOne(
            'SELECT attendee.attendee_id, attendee.first_name, attendee.last_name,
                    attendee.email, attendee.username, attendee.password,
                    role.name AS role_name
             FROM attendee
             JOIN role ON attendee.role_id = role.role_id
             WHERE attendee.username = :username', 'UserModel',
            ['username' => $username]
        );
    }

    /**
     * Inserts a new user with a hashed password.
     *
     * @param string $role The name of the role; defaults to attendee.
     * @return bool True if the user was inserted, false if validation failed.
     */
    public function insert(string $firstName, string $lastName, string $email, string $username, string $password,
                           string $role = 'attendee'): bool {
        $input = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => $role
        ];

        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $roleModel = new RoleModel();
        $userRole = $roleModel->getByName($input['role']);

        if (!$userRole) {
            return false;
        }

        $this->query(
            'INSERT INTO attendee (first_name, last_name, email, username, password, role_id)
             VALUES (:first_name, :last_name, :email, :username, :password, :role_id)',
            [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'username' => $input['username'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'role_id' => $userRole->getRoleId()
            ]
        );

        return true;
    }

    /**
     * Retrieves all users together with the name of their role.
     *
     * @return array The array of UserModel objects.
     */
    public function getAll(): array {
        return $this->queryAll(
            'SELECT attendee.attendee_id, attendee.first_name, attendee.last_name,
                    attendee.email, attendee.username, role.name AS role_name
             FROM attendee
             JOIN role ON attendee.role_id = role.role_id
             ORDER BY attendee.last_name', 'UserModel'
        );
    }

    /**
     * Retrieves a single user by id.
     *
     * @param int $id The id of the user.
     * @return object|false The UserModel object if found, false otherwise.
     */
    public function getById(int $id): object|false {
        return $this->queryOne(
            'SELECT attendee.attendee_id, attendee.first_name, attendee.last_name,
                    attendee.email, attendee.username, role.name AS role_name
             FROM attendee
             JOIN role ON attendee.role_id = role.role_id
             WHERE attendee.attendee_id = :id', 'UserModel',
            ['id' => $id]
        );
    }

    /**
     * Updates an existing user. The password is not changed here.
     *
     * @return bool True if the user was updated, false if validation failed.
     */
    public function update(int $id, string $firstName, string $lastName, string $email, string $username, string $role): bool {
        $input = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'username' => $username,
            'role' => $role
        ];

        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $roleModel = new RoleModel();
        $userRole = $roleModel->getByName($input['role']);

        if (!$userRole) {
            return false;
        }

        $this->query(
            'UPDATE attendee
             SET first_name = :first_name, last_name = :last_name, email = :email,
                 username = :username, role_id = :role_id
             WHERE attendee_id = :id',
            [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'username' => $input['username'],
                'role_id' => $userRole->getRoleId(),
                'id' => $id
            ]
        );

        return true;
    }


    /**
     * Deletes a user and all their event registrations.
     *
     * @param int $id The id of the user.
     * @return int The number of deleted rows.
     */
    public function delete(int $id): int {
        $this->query('DELETE FROM attendee_event WHERE attendee_id = :id', ['id' => $id]);
        return $this->query('DELETE FROM attendee WHERE attendee_id = :id', ['id' => $id]);
    }

    /**
     * Retrieves all users registered for the given event.
     *
     * @param int $eventId The id of the event.
     * @return array The array of UserModel objects.
     */
    public function getByEvent(int $eventId): array {
        return $this->queryAll(
            'SELECT attendee.attendee_id, attendee.first_name, attendee.last_name,
                    attendee.email, attendee.username
             FROM attendee
             JOIN attendee_event ON attendee.attendee_id = attendee_event.attendee_id
             WHERE attendee_event.event_id = :event_id
             ORDER BY attendee.last_name', 'UserModel',
            ['event_id' => $eventId]
        );
    }

    /**
     * Retrieves all users who are not yet registered for the given event.
     *
     * @param int $eventId The id of the event.
     * @return array The array of UserModel objects.
     */
    public function getNotRegistered(int $eventId): array {
        return $this->queryAll(
            'SELECT attendee.attendee_id, attendee.first_name, attendee.last_name,
                    attendee.email, attendee.username
             FROM attendee
             LEFT JOIN attendee_event
                    ON attendee.attendee_id = attendee_event.attendee_id
                   AND attendee_event.event_id = :event_id
             WHERE attendee_event.attendee_id IS NULL
             ORDER BY attendee.last_name', 'UserModel',
            ['event_id' => $eventId]
        );
    }
}
