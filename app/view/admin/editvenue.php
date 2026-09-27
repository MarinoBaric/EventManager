<?php /** @var array $data */ ?>

    <h2>Edit Venue</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/updatevenue" method="post">

        <input type="hidden" name="venue_id" value="<?php echo $data['venue']->getVenueId(); ?>">

        <label for="venueName">Venue Name:</label>
        <input type="text" id="venueName" name="venueName"
               value="<?php echo $data['venue']->getName(); ?>">

        <br><br>

        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity"
               value="<?php echo $data['venue']->getCapacity(); ?>">

        <br><br>

        <button type="submit">Save</button>

    </form>