<?php

use yii\db\Connection;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

// check if the database connection is successful
if (!isset($config['components']['db'])) {
    throw new Exception('Database configuration is missing in the application config.');
}
try {
    $db = new Connection($config['components']['db']);
    $db->open();

    // Check if the database exists
    $databaseExists = $db->createCommand("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :databaseName")
        ->bindValue(':databaseName', $_ENV['DB_NAME'])
        ->queryScalar();

    if (!$databaseExists) {
        // run install.sql to create the database
        $sqlScript = file_get_contents(__DIR__ . '/../../install.sql');
        $db->createCommand($sqlScript)->execute();
    }

} catch (\Exception $e) {
    Yii::error('Database connection failed: ' . $e->getMessage(), __METHOD__);
}

(new yii\web\Application($config))->run();
