<?php /** @var array $data */ ?>

    <h2><?php echo $data['event']->getEventName(); ?></h2>

    <p>Venue: <?php echo $data['event']->getVenueName(); ?></p>
    <p>Start Date: <?php echo $data['event']->getStartDate(); ?></p>
    <p>End Date: <?php echo $data['event']->getEndDate(); ?></p>
    <p>Registered: <?php echo $data['event']->getRegisteredNumber(); ?> / <?php echo $data['event']->getAllowedNumber(); ?></p>

    <a href="<?php echo PROJECT_URL ?>/event/registerevent/<?php echo $data['event']->getEventId(); ?>">Register</a>

    <br><br>

    <a href="<?php echo PROJECT_URL ?>/event/events">Back to Events</a>