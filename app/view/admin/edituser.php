<?php /** @var array $data */ ?>

    <h2>Edit User</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/updateuser" method="post">

        <input type="hidden" name="attendee_id" value="<?php echo $data['user']->getAttendeeId(); ?>">

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"
               value="<?php echo $data['user']->getFirstName(); ?>">

        <br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"
               value="<?php echo $data['user']->getLastName(); ?>">

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="<?php echo $data['user']->getEmail(); ?>">

        <br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username"
               value="<?php echo $data['user']->getUsername(); ?>">

        <br><br>

        <label for="userRole">Role:</label>
        <select id="userRole" name="userRole">
            <?php foreach ($data['roles'] as $role): ?>
                <option value="<?php echo $role->getName(); ?>"
                    <?php if ($role->getName() === $data['user']->getRoleName()) { echo 'selected'; } ?>>
                    <?php echo $role->getName(); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Save</button>

    </form>