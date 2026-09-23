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
}
