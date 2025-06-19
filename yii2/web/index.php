<?php

//use yii\db\Connection;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

/*
// test a database connection
$dbConfig = require __DIR__ . '/../config/db.php';

try {
    $db = new Connection($dbConfig);
    $db->open();
    echo "Database connection successful!";
} catch (\Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
}
*/

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
