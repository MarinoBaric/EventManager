<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="<?php echo PROJECT_URL ?>/public/css/style.css">
</head>

<body>

    <h1>Event Management</h1>

    <?php if (!empty($data['role'])): ?>
    <nav>
        <a href="<?php echo PROJECT_URL ?>/event/events">All Events</a>
        <a href="<?php echo PROJECT_URL ?>/event/myevents">My Events</a>
        <?php if ($data['role'] === 'admin'): ?>
            <a href="<?php echo PROJECT_URL ?>/admin/admin">Admin</a>
            <a href="<?php echo PROJECT_URL ?>/admin/venues">Venues</a>
            <a href="<?php echo PROJECT_URL ?>/admin/users">Users</a>
        <?php endif; ?>
        <a href="<?php echo PROJECT_URL ?>/user/logout">Logout</a>
    </nav>
    <?php endif; ?>