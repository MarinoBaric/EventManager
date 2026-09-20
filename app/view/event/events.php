<?php /** @var array $data */ ?>

    <h2>All Events</h2>

    <table>

        <tr>
            <th>Event</th>
            <th>Venue</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data['events'] as $event): ?>
            <tr>
                <td><?php echo $event->getEventName(); ?></td>
                <td><?php echo $event->getVenueName(); ?></td>
                <td><?php echo $event->getStartDate(); ?></td>
                <td><?php echo $event->getEndDate(); ?></td>
                <td>
                    <?php echo $event->getRegisteredNumber(); ?> / <?php echo $event->getAllowedNumber(); ?>
                </td>
                <td>
                    <a href="<?php echo PROJECT_URL ?>/event/eventdetails/<?php echo $event->getEventId(); ?>">View</a>
                    <a href="<?php echo PROJECT_URL ?>/event/registerevent/<?php echo $event->getEventId(); ?>">Register</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
