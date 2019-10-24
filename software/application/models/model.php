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
     * @return array The results of the select query as an array containing an element for each
     * field of the table with name tableName or NULL if the array of primary key's values is
     * invalid (it contains values that are null, empty or whitespaces) or no model is found.
     */
    protected function getModelByKey(array $keys): ?array
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
        $queryResult = $statement->fetch(PDO::FETCH_ASSOC);

        //Return the results
        if (is_array($queryResult)) {
            return $queryResult;
        } else {
            return null;
        }

    }

    /**
     * Inserts a model into the MySQL table whose name corresponds to the value of field tableName.
     * @param array $keys An array that contains an element of type string for each primary key defined inside array primaryKeyNames.
     * @return bool true if the insertion was successful, false otherwise.
     */
    protected function addModel(array $keys): bool
    {
        //Write the query that will write into the database
        $query = "INSERT INTO $this->tableName(" . implode(", ", $this->primaryKeyNames) . ") VALUES (";

        //Loop each element of array keys and create a placeholder for each of them
        for ($i = 0; $i < count($keys) - 1; ++$i) {
            $query .= ":key$i, ";
        }
        $query .= ":key" . (count($keys) - 1) . ")";

        print $query;

        //Prepare the statement
        $statement = $this->database->prepare($query);

        //Bind each placeholder to its respective key
        for ($i = 0; $i < count($keys); ++$i) {
            $statement->bindParam(":key$i", $keys[$i]);
        }

        //Execute the statement
        return $statement->execute();
    }

    /**
     * Deletes a record from the MySQL table whose name is equal to the value of field 'tableName'.
     * @param array $keys The table's primary key values for a row.
     * @return bool true if the deletion is successful, false otherwise.
     */
    protected function deleteModel(array $keys): bool
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

        for ($i = 0; $i < count($keys) - 1; ++$i) {

            $condition .= $this->primaryKeyNames[$i] . " = :key$i AND ";

        }

        $condition .= $this->primaryKeyNames[count($keys) - 1] . " = :key" . (count($keys) - 1);

        return $condition;

    }

}