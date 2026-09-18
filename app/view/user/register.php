

    <h2>Register</h2>

        <form action="<?php echo PROJECT_URL ?>/user/insertuser" method="post">

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

        <button type="submit">Register</button>

    </form>

    <p>Already have an account?</p>
    <a href="<?php echo PROJECT_URL ?>/user/login">Login</a>

