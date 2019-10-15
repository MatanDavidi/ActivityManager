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
     * @var array The name of the table fields that correspond to the table's primary key.
     */
    private $primaryKeyNames;

    /**
     * @var PDO The connection to the database.
     */
    protected $database;

    /**
     * Constructor function for class Model.
     * @param $tableName string The name of the table to manage with this instance of class Model.
     * @param $primaryKeyNames array The name of the table fields that correspond to the table's primary key.
     */
    public function __construct(string $tableName, array $primaryKeyNames)
    {
        $this->tableName = $tableName;
        $this->primaryKeyNames = $primaryKeyNames;
        $this->database = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_USERNAME, DB_PASSWORD);
    }

    /**
     * Gets a single model identified by its primary key.
     * @param array $keys The table's primary key values for a row.
     * @return array The results of the select query as a bidimensional array containing one or zero rows of the table
     * with name tableName.
     */
    protected function getModelByKey(array $keys): array
    {

        //Write the beginning of the query to search in the database
        $query = "SELECT * FROM $this->tableName WHERE ";

        //Compose the query using
        for ($i = 0; $i < count($keys) - 1; ++$i) {

            $query .= $this->primaryKeyNames[$i] . " = :name$i AND ";

        }

        $query .= $this->primaryKeyNames[count($keys) - 1] . " = :name" . (count($keys) - 1);

        //Prepare the query
        $statement = $this->database->prepare($query);
        //Assign to placeholders ':nameN' the value of parameter 'keys'
        for ($i = 0; $i < count($keys); ++$i) {
            $statement->bindParam(":key$i", $keys[$i]);
        }
        //Execute the query
        $statement->execute();
        //Fetch the results
        $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return the results
        return $queryResult;

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