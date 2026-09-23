<?php /** @var array $data */ ?>

    <h2>Add Event</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/insertevent" method="post">

        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName">

        <br><br>

        <label for="startDate">Start Date:</label>
        <input type="datetime-local" id="startDate" name="startDate">

        <br><br>

        <label for="endDate">End Date:</label>
        <input type="datetime-local" id="endDate" name="endDate">

        <br><br>

        <label for="allowedNumber">Allowed Number:</label>
        <input type="number" id="allowedNumber" name="allowedNumber">

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

        <button type="submit">Add</button>

    </form>