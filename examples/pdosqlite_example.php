<?php

ini_set('display_errors', true);
error_reporting(E_ALL && E_STRICT);
set_include_path(dirname(dirname(__FILE__)).'/src'.PATH_SEPARATOR.dirname(dirname(__FILE__)).'/lib/php');
require_once 'UNL/Geography/SpatialData/Campus.php';
require_once 'UNL/Geography/SpatialData/DriverInterface.php';
require_once 'UNL/Geography/SpatialData/SQLiteDriver.php';
require_once 'UNL/Geography/SpatialData/PDOSQLiteDriver.php';

UNL_Geography_SpatialData_Campus::$driver = new UNL_Geography_SpatialData_PDOSQLiteDriver();

include dirname(__FILE__).'/spatialdata_example.php';