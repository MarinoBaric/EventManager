<?php

/**
 * Description of VenueModel responsible for venue data.
 *
 * @extends Model
 */
class VenueModel extends Model {

    private $venue_id;
    private $name;
    private $capacity;

    /**
     * Validation rules for venue input.
     *
     * @var array
     */
    private $validationRules = [
        'name' => [
            'required' => true,
            'max_length' => 50
        ],
        'capacity' => [
            'required' => true,
            'numeric' => true
        ]
    ];

    public function getVenueId() {
        return $this->venue_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    /**
     * Retrieves all venues from the database.
     *
     * @return array The array of VenueModel objects.
     */
    public function getAll(): array {
        return $this->queryAll('SELECT venue_id, name, capacity FROM venue ORDER BY name', 'VenueModel');
    }

    /**
     * Retrieves a single venue by its id.
     *
     * @param int $id The id of the venue.
     * @return object|false The VenueModel object if found, false otherwise.
     */
    public function getById(int $id): object|false {
        return $this->queryOne(
            'SELECT venue_id, name, capacity FROM venue WHERE venue_id = :id',
            'VenueModel', ['id' => $id]
        );
    }

    /**
     * Inserts a new venue.
     *
     * @param string $name The name of the venue.
     * @param int $capacity The capacity of the venue.
     * @return bool True if the venue was inserted, false if validation failed.
     */
    public function insert(string $name, int $capacity): bool {
        $input = ['name' => $name, 'capacity' => $capacity];
        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $this->query('INSERT INTO venue (name, capacity) VALUES (:name, :capacity)', $input);
        return true;
    }

    /**
     * Updates an existing venue.
     *
     * @param int $id The id of the venue.
     * @param string $name The name of the venue.
     * @param int $capacity The capacity of the venue.
     * @return bool True if the venue was updated, false if validation failed.
     */
    public function update(int $id, string $name, int $capacity): bool {
        $input = ['name' => $name, 'capacity' => $capacity];
        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $input['id'] = $id;
        $this->query('UPDATE venue SET name = :name, capacity = :capacity WHERE venue_id = :id', $input);
        return true;
    }

    /**
     * Deletes a venue.
     *
     * @param int $id The id of the venue.
     * @return int The number of deleted rows.
     */
    public function delete(int $id): int {
        return $this->query('DELETE FROM venue WHERE venue_id = :id', ['id' => $id]);
    }
}
