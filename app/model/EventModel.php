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
}
