    <h2>Add Venue</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/insertvenue" method="post">

        <label for="venueName">Venue Name:</label>
        <input type="text" id="venueName" name="venueName">

        <br><br>

        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity">

        <br><br>

        <button type="submit">Add</button>

    </form>