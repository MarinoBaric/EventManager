<?php /** @var array $data */ ?>

    <h2>Add User</h2>

    <form action="<?php echo PROJECT_URL ?>/admin/insertuser" method="post">

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName">

        <br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName">

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <br><br>

        <label for="userRole">Role:</label>
        <select id="userRole" name="userRole">
            <?php foreach ($data['roles'] as $role): ?>
                <option value="<?php echo $role->getName(); ?>">
                    <?php echo $role->getName(); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Add</button>

    </form>