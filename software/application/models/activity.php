<?php

require_once "application/models/model.php";

/**
 * Class Lavoro
 */
class Activity extends Model
{

    /**
     * @var string The name of this activity.
     */
    private $name;

    /**
     * @var string The notes that may be associated with it.
     */
    private $notes;

    /**
     * @var DateTime The beginning date of the activity.
     */
    private $startDate;

    /**
     * @var DateTime The delivery date of the activity.
     */
    private $deliveryDate;

    /**
     * @var int The estimated number of hours that will be spent working on the activity.
     */
    private $estimatedHours;

    /**
     * Constructor function for class Activity.
     * @param $name string The name of the activity.
     * @param $notes string The notes that may be associated with it.
     * @param $startDate DateTime The beginning date of the activity.
     * @param $deliveryDate DateTime The delivery date of the activity.
     * @param $estimatedHours int The estimated number of hours that will be spent working on the activity.
     */
    public function __construct(string $name = null, string $notes = null, DateTime $startDate = null, DateTime $deliveryDate = null, int $estimatedHours = null)
    {
        parent::__construct("lavoro");
        $this->name = $name;
        $this->notes = $notes;
        $this->startDate = $startDate;
        $this->deliveryDate = $deliveryDate;
        $this->estimatedHours = $estimatedHours;
    }

    /**
     * Get all activities reading their data from the database.
     * @return array An array containing a object of type Activity for each line read from the database.
     */
    public function getAllActivities(): Array
    {

        //Instantiates the array that will be returned.
        $activities = [];
        //Get the database's data thanks to superclass 'Model'.
        $models = $this->getAllModels();

        // Loop through each element read from the database and for each of them add an object of
        // type Activity with the data from the current element from models to array activities.
        foreach ($models as $model) {

            array_push(
                $activities,
                new Activity(
                    $model["nome"],
                    $model["note"],
                    DateTime::createFromFormat("Y-m-d", $model["data_inizio"]),
                    DateTime::createFromFormat("Y-m-d", $model["data_consegna"]),
                    intval($model["ore_preventivate"])
                )
            );

        }

        return $activities;

    }

    /**
     * Gets an activity with the specified name.
     * @param string $name The name for which to search for a job in the database.
     * @return Activity An object whose fields' values are equal to the data of the line
     * of the database's table whose name corresponds to the value of parameter 'name'.
     */
    public function getActivityByName(string $name): Activity
    {
        //TODO: Generalize this method?

        //Write the query to search in the database
        $query = "SELECT * FROM lavoro WHERE nome = :name";
        //Prepare the query
        $statement = $this->database->prepare($query);
        //Assign to placeholder ':name' the value of parameter 'name'
        $statement->bindParam(":name", $name);
        //Execute the query
        $statement->execute();
        //Fetch the results
        $queryResult = $statement->fetchAll();

        //If a result has been returned
        if (count($queryResult) > 0) {

            //Return a new object of type Activity with the result's data
            return new Activity(
                $queryResult[0]["nome"],
                $queryResult[0]["note"],
                DateTime::createFromFormat("Y-m-d", $queryResult[0]["data_inizio"]),
                DateTime::createFromFormat("Y-m-d", $queryResult[0]["data_consegna"]),
                intval($queryResult[0]["ore_preventivate"])
            );

        }

        //If we got to this point, it means a result was not found, so return null
        return null;

    }

    /**
     * Inserts a new row into table 'lavoro' of database with data passed as parameter.
     * @param Activity $activity The data to add to the database.
     * @return bool true if the insert operation is successful, false otherwise
     */
    public function addActivity(Activity $activity): bool
    {

        $startDate = $activity->startDate;
        $deliveryDate = $activity->deliveryDate;

        $startDateString = $startDate->format("Y-m-d");
        $deliveryDateString = $deliveryDate->format("Y-m-d");

        //Write the query that will write into the database.
        $query = "INSERT INTO lavoro(nome, note, data_inizio, data_consegna, ore_preventivate) VALUES (:name, :notes, :startDate, :deliveryDate, :hours)";
        //Prepare the query.
        $statement = $this->database->prepare($query);
        //Replace placeholder ':name' with activity name taken from field 'name' of 'activity' parameter.
        $statement->bindParam(":name", $activity->name);
        //Replace placeholder ':notes' with activity notes taken from field 'notes' of 'activity' parameter.
        $statement->bindParam(":notes", $activity->notes);
        //Replace placeholder ':startDate' with activity starting
        //date taken from field 'startDate' of 'activity' parameter.
        $startDate = $activity->startDate;
        $statement->bindParam(":startDate", $startDateString);
        //Replace placeholder ':deliveryDate' with activity delivery
        //date taken from field 'deliveryDate' of 'activity' parameter.
        $statement->bindParam(":deliveryDate", $deliveryDateString);
        //Replace placeholder ':hours' with activity estimated hours
        //taken from field 'estimatedHours' of 'activity' parameter.
        $statement->bindParam(":hours", $activity->estimatedHours);

        //Return the result of query execution
        $result = $statement->execute();
        return $result;

    }

}