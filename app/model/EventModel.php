<?php

/** 
 * Description of EventModel responsible for event data.
 * 
 * Retrieves events from the database, joined with their venue and with the 
 * number of registered attendees, and provides the create, update and delete 
 * operations for events.
 *
 * @extends Model
 */
class EventModel extends Model{
    private $event_id;          
    private $event_name;
    private $start_date;
    private $end_date;
    private $allowed_number;
    private $venue_name;
    private $registered_number;

    private $validationRules = [
        'name' => [
            'required' => true,
            'max_length' => 50
        ],
        'start_date' => [
            'required' => true
        ],
        'end_date' => [
            'required' => true
        ],
        'allowed_number' => [
            'required' => true,
            'numeric' => true
        ],
        'venue_id' => [
            'required' => true,
            'numeric' => true
        ]
    ];

    public function getEventId() {
        return $this->event_id;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getAllowedNumber() {
        return $this->allowed_number;
    }

    public function getRegisteredNumber() {
        return $this->registered_number;
    }

    public function getEventName(){
        return $this->event_name;
    }

    public function getVenueName(){
        return $this->venue_name;
    }

    /**
     * Retrieves all events together with their venue and the number of
     * registered attendees.
     *
     * @return array The array of EventModel objects.
     */
    public function getAll(): array {
        return $this->queryAll(
            'SELECT event.event_id, event.name AS event_name, event.start_date, event.end_date,
                    event.allowed_number, venue.name AS venue_name,
                    COUNT(attendee_event.attendee_id) AS registered_number
             FROM event JOIN venue ON event.venue_id = venue.venue_id
             LEFT JOIN attendee_event ON event.event_id = attendee_event.event_id
             GROUP BY event.event_id', 'EventModel'
        );
    }

    /**
     * Retrieves a single event by its id.
     *
     * @param int $id The id of the event.
     * @return object|false The EventModel object if found, false otherwise.
     */
    public function getById(int $id): object | false {
        return $this->queryOne(
            'SELECT event.event_id, event.name AS event_name, event.start_date, event.end_date,
                    event.allowed_number, venue.name AS venue_name,
                    COUNT(attendee_event.attendee_id) AS registered_number
             FROM event JOIN venue ON event.venue_id = venue.venue_id
             LEFT JOIN attendee_event ON event.event_id = attendee_event.event_id
             WHERE event.event_id = :id
             GROUP BY event.event_id', 'EventModel',
            ['id' => $id]
        );
    }

    /**
     * Deletes an event and all registrations for it.
     *
     * @param int $id The id of the event.
     * @return int The number of deleted rows.
    */
    public function delete(int $id): int {
        $this->query('DELETE FROM attendee_event WHERE event_id = :id', ['id' => $id]);
        return $this->query('DELETE FROM event WHERE event_id = :id', ['id' => $id]);
    }

    /**
     * Updates an existing event.
     *
     * @return int The number of updated rows.
    */
    public function update(int $id, string $name, string $startDate,
                           string $endDate, int $allowedNumber, int $venueId): bool {
        $input = [
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'allowed_number' => $allowedNumber,
            'venue_id' => $venueId
        ];

        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $input['id'] = $id;

        $this->query(
            'UPDATE event
             SET name = :name, start_date = :start_date, end_date = :end_date,
                 allowed_number = :allowed_number, venue_id = :venue_id
             WHERE event_id = :id',
            $input
        );

        return true;
    }

    /**
     * Inserts a new event.
     *
     * @return int The number of inserted rows.
    */
    public function insert(string $name, string $startDate, string $endDate,
                           int $allowedNumber, int $venueId): bool {
        $input = [
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'allowed_number' => $allowedNumber,
            'venue_id' => $venueId
        ];

        $input = $this->sanitize($input);

        if (!$this->validate($input, $this->validationRules)) {
            return false;
        }

        $this->query(
            'INSERT INTO event (name, start_date, end_date, allowed_number, venue_id)
             VALUES (:name, :start_date, :end_date, :allowed_number, :venue_id)',
            $input
        );

        return true;
    }

    /**
     * Retrieves all events the given attendee has registered for.
     *
     * @param int $attendeeId The id of the attendee.
     * @return array The array of EventModel objects.
    */
    public function getByAttendee(int $attendeeId): array {
        return $this->queryAll(
            'SELECT event.event_id, event.name AS event_name, event.start_date,
                    event.end_date, event.allowed_number, venue.name AS venue_name
             FROM event
             JOIN venue ON event.venue_id = venue.venue_id
             JOIN attendee_event ON event.event_id = attendee_event.event_id
             WHERE attendee_event.attendee_id = :attendee_id
             ORDER BY event.start_date', 'EventModel',
            ['attendee_id' => $attendeeId]
        );
    }

    /**
     * Registers the given attendee for the given event.
     *
     * @param int $attendeeId The id of the attendee.
     * @param int $eventId The id of the event.
     * @return int The number of inserted rows.
     */
    public function register(int $attendeeId, int $eventId): int {
        return $this->query(
            'INSERT INTO attendee_event (attendee_id, event_id)
             VALUES (:attendee_id, :event_id)',
            ['attendee_id' => $attendeeId, 'event_id' => $eventId]
        );
    }

    /**
     * Removes the given attendee's registration for the given event.
     *
     * @param int $attendeeId The id of the attendee.
     * @param int $eventId The id of the event.
     * @return int The number of deleted rows.
     */
    public function unregister(int $attendeeId, int $eventId): int {
        return $this->query(
            'DELETE FROM attendee_event
             WHERE attendee_id = :attendee_id AND event_id = :event_id',
            ['attendee_id' => $attendeeId, 'event_id' => $eventId]
        );
    }

    
}