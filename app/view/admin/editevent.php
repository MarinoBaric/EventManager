<?php /** @var array $data */ ?>

    <h2>Edit Event</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/updateevent" method="post">

        <input type="hidden" name="event_id" value="<?php echo $data['event']->getEventId(); ?>">

        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName"
               value="<?php echo $data['event']->getEventName(); ?>">

        <br><br>

        <label for="startDate">Start Date:</label>
        <input type="datetime-local" id="startDate" name="startDate"
               value="<?php echo str_replace(' ', 'T', $data['event']->getStartDate()); ?>">

        <br><br>

        <label for="endDate">End Date:</label>
        <input type="datetime-local" id="endDate" name="endDate"
               value="<?php echo str_replace(' ', 'T', $data['event']->getEndDate()); ?>">

        <br><br>

        <label for="allowedNumber">Allowed Number:</label>
        <input type="number" id="allowedNumber" name="allowedNumber"
               value="<?php echo $data['event']->getAllowedNumber(); ?>">

        <br><br>

        <label for="venue">Venue:</label>
        <select id="venue" name="venue">
            <?php foreach ($data['venues'] as $venue): ?>
                <option value="<?php echo $venue->getVenueId(); ?>">
                    <?php echo $venue->getName(); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Save</button>

    </form>