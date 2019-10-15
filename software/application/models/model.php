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
     * Gets all data from the table whose name corresponds to the value of field 'tableName'.
     * @return array An associative array containing all data that was read from the database.
     */
    protected function getAllModels(): array
    {

        $statement = $this->database->prepare("SELECT * FROM $this->tableName");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

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

        //Compose the condition of the query
        $query .= $this->composePrimaryKeyCondition($keys);

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
     * Deletes a record from the MySQL table whose name is equal to the value of field 'tableName'.
     * @param array $keys The table's primary key values for a row.
     * @return bool true if the deletion is successful, false otherwise.
     */
    public function deleteModel(array $keys): bool
    {
        //Write the beginning of the query to delete from a table in the database
        $query = "DELETE FROM $this->tableName WHERE ";

        //Compose the condition of the query
        $query .= $this->composePrimaryKeyCondition($keys);

        //Prepare the query
        $statement = $this->database->prepare($query);

        //Assign to placeholders ':nameN' the value of parameter 'keys'
        for ($i = 0; $i < count($keys); ++$i) {
            $statement->bindParam(":key$i", $keys[$i]);
        }

        //Execute the query
        return $statement->execute();

    }

    /**
     * Composes the part of a MySQL query that contains the conditions where the primary key is equal to a value.
     * @param array $keys The names of the fields that make up the primary key.
     * @return string The condition part of a MySQL query that checks if the primary key is equal to a value.
     * For example:
     * composePrimaryKeyCondition(["primary_key_1", "primary_key_2"]);
     * Will return: "primary_key_1 = :key1 AND primary_key_2 = :key2".
     */
    private function composePrimaryKeyCondition(array $keys): string
    {

        $condition = "";

        //Compose the query using
        for ($i = 0; $i < count($keys) - 1; ++$i) {

            $condition .= $this->primaryKeyNames[$i] . " = :key$i AND ";

        }

        $condition .= $this->primaryKeyNames[count($keys) - 1] . " = :key" . (count($keys) - 1);

        return $condition;

    }

}