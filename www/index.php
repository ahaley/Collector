<?php

require_once '../SplClassLoader.php';

$loader = new SplClassLoader('Doctrine', '/usr/lib/php/pear');
$loader->register();


if ($_SERVER['REQUEST_METHOD'] != "POST") {
    require_once 'form.html';
    die();
}

$collectedValues = array(
    'name', 'email'
);

$config = new \Doctrine\DBAL\Configuration();
$params = array(
    'dbname' => 'cieditions_collector',
    'user' => 'mysql',
    'password' => 'mysql',
    'host' => 'localhost',
    'driver' => 'pdo_mysql'
);

$conn = \Doctrine\DBAL\DriverManager::getConnection($params, $config);

$user_info = array();
foreach ($collectedValues as $value) {
    if (isset($_POST[$value])) {
        $user_info[$value] = $conn->quote($_POST[$value]);
    }
}

if ($conn->insert('user_info', $user_info) == 1) {
    echo "User info collected";
}
else {
    echo "User info not collected";
}
