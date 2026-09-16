

    <h2>Login</h2>

    <form action="<?php echo PROJECT_URL ?>/user/welcome" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p>Don't have an account?</p>
    <a href="<?php echo PROJECT_URL ?>/user/register">Register</a>
