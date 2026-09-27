<?php /** @var array $data */ ?>

    <h2>Users</h2>

    <a href="<?php echo PROJECT_URL ?>/admin/adduser">Add User</a>

    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td><?php echo $user->getFirstName(); ?></td>
                <td><?php echo $user->getLastName(); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
                <td><?php echo $user->getUsername(); ?></td>
                <td><?php echo $user->getRoleName(); ?></td>
                <td>
                    <a href="<?php echo PROJECT_URL ?>/admin/edituser/<?php echo $user->getAttendeeId(); ?>">Edit</a>
                    <a href="<?php echo PROJECT_URL ?>/admin/deleteuser/<?php echo $user->getAttendeeId(); ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>