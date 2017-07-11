<?php

// GET /visit-counter.php initialises a session and returns the number
// of requests already made by a given authenticated client.
// This is the main test script that exercises the RedisSessionHandler.

require_once __DIR__.'/../../vendor/autoload.php';

if (isset($_GET['with_no_time_limit'])) {
    set_time_limit(0);
} elseif (isset($_GET['with_custom_cookie_params'])) {
    session_set_cookie_params(86400, '/', '', true, true);
} elseif (isset($_GET['with_url_based_sessions'])) {
    ini_set("session.use_cookies", 0);
    ini_set("session.use_only_cookies", 0);
    ini_set("session.use_trans_sid", 1);
}

session_set_save_handler(new \UMA\RedisSessionHandler(), true);

session_start();

if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}

echo ++$_SESSION['visits'];

if (isset($_GET['with_url_based_sessions'])) {
    echo '<a href="visit-counter.php">Link</a>';
}
