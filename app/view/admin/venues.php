<?php /** @var array $data */ ?>

    <h2>Venues</h2>

    <a href="<?php echo PROJECT_URL ?>/admin/addvenue">Add Venue</a>

    <table>
        <tr>
            <th>Venue</th>
            <th>Capacity</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data['venues'] as $venue): ?>
            <tr>
                <td><?php echo $venue->getName(); ?></td>
                <td><?php echo $venue->getCapacity(); ?></td>
                <td>
                    <a href="<?php echo PROJECT_URL ?>/admin/editvenue/<?php echo $venue->getVenueId(); ?>">Edit</a>
                    <a href="<?php echo PROJECT_URL ?>/admin/deletevenue/<?php echo $venue->getVenueId(); ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>