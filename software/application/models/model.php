<?php

/**
 * Class Model
 */
class Model
{

    /**
     * @var string The name of the table to manage with this instance of class Model.
     */
    private $tableName;

    /**
     * @var PDO The connection to the database.
     */
    protected $database;

    /**
     * Constructor function for class Model.
     * @param $tableName string The name of the table to manage with this instance of class Model.
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->database = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_USERNAME, DB_PASSWORD);
    }

    /**
     * Gets all data from the table whose name corresponds to the value of field 'tableName'.
     * @return array An associative array containing all data that was read from the database.
     */
    protected function getAllModels(): Array
    {

        $statement = $this->database->prepare("SELECT * FROM $this->tableName");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }


}