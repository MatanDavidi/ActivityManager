<?php


class Model
{

    /**
     * @var string Il nome della tabella da gestire con quest'istanza di Model.
     */
    private $tableName;

    /**
     * @var PDO La connessione al database.
     */
    private $database;

    /**
     * Costruttore per la classe Model
     * @param $tableName string Il nome della tabella da gestire con quest'istanza di Model.
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->database = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_USERNAME, DB_PASSWORD);
    }

    public function getAllModels(): Array
    {

        $statement = $this->database->prepare("SELECT * FROM $this->tableName");
        return $statement->fetchAll(PDO::FETCH_NUM);

    }


}