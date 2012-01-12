<?php
function autoload($class)
{
    $class = str_replace('_', '/', $class);
    include $class . '.php';
}
    
spl_autoload_register("autoload");

set_include_path(dirname(__FILE__).'/src'.PATH_SEPARATOR.dirname(__FILE__).'/lib/php');

@unlink('data/spatialdata.sqlite');
@unlink('data/spatialdata.pdo.sqlite');

foreach (array('UNL_Geography_SpatialData_SQLiteDriver', 'UNL_Geography_SpatialData_PDOSQLiteDriver') as $driver) {
    echo "Setting up $driver\n";
    UNL_Geography_SpatialData_Campus::$driver = new $driver();

    // Now trigger database update by requesting data
    $campus = new UNL_Geography_SpatialData_Campus();
    $campus->getGeoCoordinates('501');
}

