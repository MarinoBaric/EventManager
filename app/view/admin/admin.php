    <?php /** @var array $data */ ?>


    <h2>Events</h2>

        <a href="<?php echo PROJECT_URL ?>/admin/addevent">Add Event</a>

    <table>

        <tr>
            <th>Event</th>
            <th>Venue</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data['events'] as $event): ?>
            <tr>
                <td><?php echo $event->getEventName(); ?></td>
                <td><?php echo $event->getVenueName(); ?></td>
                <td><?php echo $event->getStartDate(); ?></td>
                <td><?php echo $event->getEndDate(); ?></td>
                <td>
                    <a href="<?php echo PROJECT_URL ?>/event/registered/<?php echo $event->getEventId(); ?>">
                        <?php echo $event->getRegisteredNumber(); ?>
                    </a>
                    / <?php echo $event->getAllowedNumber(); ?>
                </td>
                <td>
                    <a href="<?php echo PROJECT_URL ?>/event/eventdetails/<?php echo $event->getEventId(); ?>">View</a>
                    <a href="<?php echo PROJECT_URL ?>/admin/editevent/<?php echo $event->getEventId(); ?>">Edit</a>
                    <a href="<?php echo PROJECT_URL ?>/admin/deleteevent/<?php echo $event->getEventId(); ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
