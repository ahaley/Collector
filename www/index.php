<?php

require_once '../SplClassLoader.php';

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    require_once 'form.html';
    die();
}

//$loader = new SplClassLoader('Doctrine', __DIR__ . '/../vendor');
//$loader->register();

require_once '../vendor/autoload.php';

$collectedValues = array(
    'name', 'email'
);

$config = new \Doctrine\DBAL\Configuration();
$params = array(
    'dbname' => getenv('COLLECTOR_DB'),
    'user' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
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
