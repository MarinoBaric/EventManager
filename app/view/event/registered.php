<?php /** @var array $data */ ?>

    <h2>Registered Attendees</h2>

    <p>Event: <?php echo $data['event']->getEventName(); ?></p>

    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td><?php echo $user->getFirstName(); ?></td>
                <td><?php echo $user->getLastName(); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
                <td><?php echo $user->getUsername(); ?></td>
                <td>
                    <?php if ($data['role'] === 'admin'): ?>
                        <a href="<?php echo PROJECT_URL ?>/admin/removeattendee/<?php echo $data['event']->getEventId(); ?>/<?php echo $user->getAttendeeId(); ?>">Remove</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <?php if ($data['role'] === 'admin'): ?>
        <h3>Add Attendee</h3>

        <form action="<?php echo PROJECT_URL ?>/admin/addattendee" method="post">

            <input type="hidden" name="event_id" value="<?php echo $data['event']->getEventId(); ?>">

            <label for="attendee_id">Attendee:</label>
            <select id="attendee_id" name="attendee_id">
                <?php foreach ($data['available'] as $available): ?>
                    <option value="<?php echo $available->getAttendeeId(); ?>">
                        <?php echo $available->getFirstName(); ?> <?php echo $available->getLastName(); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add</button>

        </form>

        <br>
    <?php endif; ?>

    <br>

    <a href="<?php echo PROJECT_URL ?>/admin/admin">Back to Admin</a>