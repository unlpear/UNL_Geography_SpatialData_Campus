<?php

class UNL_Geography_SpatialData_PDOSQLiteDriver extends UNL_Geography_SpatialData_SQLiteDriver
{

    function __construct()
    {
        self::$db_file  = 'spatialdata.pdo.sqlite';
        parent::__construct();
    }

    /**
     * Connect to the database
     * 
     * @return PDO
     */
    protected function __connect()
    {
        $this->db = new PDO('sqlite:'.self::getDataDir().self::$db_file);
        return $this->db;
    }

    /**
     * Returns the geographical coordinates for a building.
     *
     * @param string $code Building Code for the building you want coordinates of.
     * @return Associative array of coordinates lat and lon. false on error.
     */
    function getGeoCoordinates($code)
    {
        $this->_checkDB();
        static $statement = false;

        if (!$statement) {
            // Prepare the SQL statement
            $statement = $this->getDB()->prepare('SELECT lat,lon FROM campus_spatialdata WHERE code = ?');
        }

        /* @var $statement PDOStatement */
        if ($statement->execute(array($code))) {
            while ($coords = $statement->fetch()) {
                return array('lat'=>$coords['lat'],
                             'lon'=>$coords['lon']);
            }
        }
        return false;
    }

    public function escape($string)
    {
        return $this->getDB()->quote($string);
    }

    protected function _getResultRowCount($result)
    {
        $column = $result->fetchColumn();
        if (!empty($column)) {
            return true;
        }

        return false;
    }

}