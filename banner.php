<?php

require_once 'Config.php';
require_once 'Mysqli_driver.php';

$db = new Mysqli__driver();
$db->connect(Config::$db['hostname'],Config::$db['username'],Config::$db['password'],Config::$db['dbName']);

$ip = $_SERVER ['REMOTE_ADDR'];
$page_url = $_SERVER['REQUEST_URI'];
$browser = $_SERVER['HTTP_USER_AGENT'];

$db->execute('
    INSERT INTO test (
        `ip_address`, `page_url`, `user_agent`, `view_date`, `views_count`
    )
    VALUES
    (
        INET_ATON(%s),
        %s,
        %s,
        null,
        1
    )
    ON DUPLICATE KEY
    UPDATE views_count = views_count + 1;', array(
        array('d' => $_SERVER ['REMOTE_ADDR']),
        array('d' => $_SERVER ['REQUEST_URI']),
        array('d' => $_SERVER ['HTTP_USER_AGENT'])
    )
);

//var_dump($_SERVER);