<?php
require_once "application/models/model.php";
require_once "application/models/activity.php";
require_once "application/models/resource.php";
require_once "application/models/assignment.php";

class WorkHours extends Model
{

    /**
     * @var Activity The activity on which the resource has worked.
     */
    private $activity;

    /**
     * @var Resource The resource that worked on the activity.
     */
    private $resource;

    /**
     * @var DateTime The date on which the work took place.
     */
    private $date;

    /**
     * @var int The number of hours the resource has worked on the activity for.
     */
    private $hoursNumber;

    /**
     * WorkHours constructor.
     * @param Activity $activity The activity for which the resource has worked.
     * @param Resource $resource The resource that worked on the activity.
     * @param DateTime $date The date on which the work took place.
     * @param int $hoursNumber The number of hours the resource has worked on the activity for.
     */
    public function __construct(Activity $activity = null, Resource $resource = null, DateTime $date = null, int $hoursNumber = null)
    {
        parent::__construct(
            "ore_lavoro",
            ["nome_lavoro", "nome_risorsa", "data", "numero_ore"],
            ["nome_lavoro", "nome_risorsa", "data", "numero_ore"]
        );
        $this->activity = $activity;
        $this->resource = $resource;
        $this->date = $date;
        $this->hoursNumber = $hoursNumber;
    }

    /**
     * Gets the activity on which the resource has worked.
     * @return Activity The activity on which the resource has worked.
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * Gets the resource that worked on the activity.
     * @return Resource The resource that worked on the activity.
     */
    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    /**
     * Gets the date on which the work took place.
     * @return DateTime The date on which the work took place.
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * Gets the number of hours the resource has worked on the activity for.
     * @return int The number of hours the resource has worked on the activity for.
     */
    public function getHoursNumber(): ?int
    {
        return $this->hoursNumber;
    }

    /**
     * Get all work hours reading their data from the database.
     * @return array An array containing a object of type WorkHours for each line read from the database.
     */
    public function getAllWorkHours()
    {
        //Instantiates the array that will be returned.
        $workHours = [];

        //Get the database's data thanks to superclass 'Model'.
        $models = $this->getAllModels();

        //Instantiate an empty object of type Activity to use its methods
        $baseActivity = new Activity();

        //Instantiate an empty object of type Resource to use its methods
        $baseResource = new Resource();

        // Loop through each element read from the database and for each of them add an object of
        // type WorkHours with the data from the current element from models to array activities.
        foreach ($models as $model) {

            //Get the activity with the same name as the current model.
            $modelActivity = $baseActivity->getActivityByName($model["nome_lavoro"]);
            //Get the resource with the same name as the current model.
            $modelResource = $baseResource->getResourceByName($model["nome_risorsa"]);

            //Only if both the model's activity and resource are not null, can we add the element to the array
            if (isset($modelActivity) &&
                isset($modelResource)) {
                //Add a new object of type WorkHours with the model's data to the array.
                array_push($workHours,
                    new WorkHours(
                        $modelActivity,
                        $modelResource,
                        DateTime::createFromFormat("Y-m-d", $model["data"]),
                        intval($model["numero_ore"])
                    )
                );
            }

        }

        return $workHours;
    }

    /**
     * Gets all work hours, with date and number of hours, of a single resource on a single activity.
     * @param Activity $activity The activity on which the resource has worked.
     * @param Resource $resource The resource that worked on the activity.
     * @return array An array of objects of type WorkHours, containing one element for each row of table 'ore_lavoro' of
     * the database whose activity and resource name correspond to the values of field 'name' of the parameters passed
     * to this function.
     */
    public function getWorkHoursOfResourceOnActivity(Activity $activity, Resource $resource): array
    {
        //The array that will contain the values to return
        $workHoursArray = [];

        //Check if activity and resource are valid
        if (!is_null($this->database) &&
            $activity->isValid() &&
            $resource->isValid()) {

            //Get the activity's name
            $activityName = $activity->getName();
            //Get the resource's name
            $resourceName = $resource->getName();

            //Create the query
            $query = "SELECT * FROM ore_lavoro WHERE nome_lavoro = :activity AND nome_risorsa = :resource";

            //Prepare the query
            $statement = $this->database->prepare($query);

            //Bind query placeholders to their respective values:
            //Bind placeholder :activity to value of 'name' field of parameter 'activity'
            $statement->bindParam(":activity", $activityName);
            //Bind placeholder :resource to value of 'name' field of parameter 'resource'
            $statement->bindParam(":resource", $resourceName);

            //Execute the statement
            if ($statement->execute()) {

                //Fetch the statement's results
                $models = $statement->fetchAll(PDO::FETCH_ASSOC);

                //If one or more rows have been returned
                if (count($models) > 0) {

                    //Loop each returned row and for each add an object of type WorkHours to array workHours.
                    foreach ($models as $model) {

                        //Get from the database the activity with the same name as activity->getName().
                        $databaseActivity = $activity->getActivityByName($model["nome_lavoro"]);

                        //If the values of its fields are the same as the ones of parameter activity
                        if ($activity->equals($databaseActivity)) {

                            //Get from the database the resource with the same name as resource->getName().
                            $databaseResource = $resource->getResourceByName($model["nome_risorsa"]);

                            //If the values of its fields are the same as the ones of parameter resource
                            if ($resource->equals($databaseResource)) {

                                //All values correspond and the resource is actually assigned to
                                //the activity: create an object with values read from database.
                                $workHours = new WorkHours
                                (
                                    $activity,
                                    $resource,
                                    DateTime::createFromFormat("Y-m-d", $model["data"]),
                                    intval($model["numero_ore"])
                                );

                                //Add the object to the array
                                array_push($workHoursArray, $workHours);

                            }

                        }

                    }

                }

            }

        }

        //Return array
        return $workHoursArray;

    }

    /**
     * Gets all hours during which any resource has worked on an activity.
     * @param Activity $activity The activity for which to filter the work hours.
     * @return array An array containing an object of type WorkHours for each row of table
     * 'ore_lavoro' of the database whose activity corresponds to the one passed as parameter.
     */
    public function getWorkHoursByActivity(Activity $activity): array
    {
        //The array that will contain the values to return
        $workHours = [];

        //Check if the activity is valid
        if (!is_null($this->database) &&
            $activity->isValid()) {

            //Get the activity's name
            $activityName = $activity->getName();
            //Write the query with which to read from the database
            $query = "SELECT * FROM ore_lavoro WHERE nome_lavoro = :activity ORDER BY data, nome_risorsa";
            //Prepare the statement
            $statement = $this->database->prepare($query);
            //Bind placeholder ':activity' to the name of the activity
            $statement->bindParam(":activity", $activityName);
            //If the statement's execution was successful
            if ($statement->execute()) {

                //Create an empty resource to use its functions
                $baseResource = new Resource();
                //Fetch all results of the statement's execution
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                //Loop through each result that was returned from the statement's execution
                foreach ($results as $result) {

                    //Get the resource assigned to the current work hours
                    $resource = $baseResource->getResourceByName($result["nome_risorsa"]);
                    //Create an object of type DateTime from the current work hours' date string
                    $date = DateTime::createFromFormat("Y-m-d", $result["data"]);
                    //Get the current work hours' hours number
                    $hoursNumber = intval($result["numero_ore"]);

                    //Create a new object of type WorkHours
                    $workHoursResult = new WorkHours($activity, $resource, $date, $hoursNumber);

                    //Add the object to the array
                    array_push($workHours, $workHoursResult);

                }

            }

        }

        //Return the array
        return $workHours;

    }

    /**
     * Gets a month's work hours by reading them from the database.
     * @param string $month A string containing the month to request in the following format: "YYYY-MM". i. e. "2019-11".
     * @return string A JSON encoded string containing the data of each work hour that was found for the specified month.
     */
    public function getWorkHoursByMonth(string $month): string
    {
        //Instantiate the array that will be turned into a JSON string and then returned
        $workHoursReturn = [];
        //Attempt a query only if a connection with the database can be established
        if (!is_null($this->database)) {
            //The month's format has to follow the format "YYYY-MM"
            if (preg_match("/^\d{4}\-\d{1,2}$/", $month)) {
                //Write the query
                $query = "SELECT * FROM ore_lavoro WHERE data LIKE '$month-%' ORDER BY data, nome_risorsa";
                //Prepare the query
                $statement = $this->database->prepare($query);
                //If the statement could be executed
                if ($statement->execute()) {
                    //Fetch the query's results
                    $workHoursArrays = $statement->fetchAll(PDO::FETCH_ASSOC);
                    //Loop through each returned row
                    foreach ($workHoursArrays as $workHoursArray) {
                        $resource = new Resource();
                        $resource = $resource->getResourceByName($workHoursArray["nome_risorsa"]);
                        //Calculate the cost of the work hours
                        $workHoursArray["costo"] = round($resource->getHourCost() * $workHoursArray["numero_ore"], 3);
                        //Add the current work hours array to the global array (that will later be encoded into JSON)
                        array_push($workHoursReturn, $workHoursArray);

                    }
                }
            }
        }
        //Encode the global array to JSON and return the encoded string
        return json_encode($workHoursReturn);
    }

    /**
     * Get all work hours of a resource on a specific date.
     * @param Resource $resource The resource of which to find the work hours.
     * @param DateTime $date The date on which to find the work hours.
     * @return string A JSON encoded string containing the data of each
     * work hour that was found for the specified resource and date.
     */
    public function getWorkHoursByDate(Resource $resource, DateTime $date): string
    {
        //Instantiate the array that will be turned into a JSON string and then returned
        $workHoursReturn = [];
        //Attempt a query only if a connection with the database can be established and the resource is valid
        if (!is_null($this->database) &&
            $resource->isValid()) {

            //Get the resource's name
            $resourceName = $resource->getName();
            //Format the DateTime object as a MySQL string
            $dateString = $date->format("Y-m-d");

            //Create the query
            $query =
                "SELECT * FROM ore_lavoro " .
                "WHERE nome_risorsa = :resource AND data = :date ORDER BY data, nome_risorsa";

            //Prepare the statement
            $statement = $this->database->prepare($query);

            //Bind query placeholders to their respective values:
            //Bind placeholder :resource to value of 'name' field of parameter 'resource'
            $statement->bindParam(":resource", $resourceName);
            //Bind placeholder :resource to MySQL-formatted value of parameter 'date'
            $statement->bindParam(":date", $dateString);

            //Execute the statement
            if ($statement->execute()) {
                $workHoursFetch = $statement->fetchAll(PDO::FETCH_ASSOC);

                //Create an empty object of type Activity to use its functions
                $baseActivity = new Activity();

                //Loop through each returned row
                foreach ($workHoursFetch as $workHour) {

                    //Calculate and add to result the work hour's cost
                    $workHour["costo"] = round($resource->getHourCost() * $workHour["numero_ore"], 3);
                    //Add the current work hours array to the global array (that will later be encoded into JSON)
                    array_push($workHoursReturn, $workHour);

                }

            }
        }
        //Encode the global array to JSON and return the encoded string
        return json_encode($workHoursReturn);

    }

    /**
     * Inserts a new row into table 'ore_lavoro' of database with data passed as parameter.
     * @param WorkHours $workHours An object of type WorkHours that contains the data to add to the database.
     * @return bool true if the insert operation is successful, false otherwise.
     */
    public function addWorkHours(WorkHours $workHours): bool
    {
        //Check if the work hours to be added to the database are valid
        if ($workHours->isValid()) {

            //Insert a new row into table 'ore_lavoro' using inherited function "addModel".
            return $this->addModel(
                [
                    $workHours->activity->getName(),
                    $workHours->resource->getName(),
                    $workHours->date->format("Y-m-d"),
                    $workHours->hoursNumber
                ]
            );

        }

        return false;

    }

    /**
     * Deletes a record from the MySQL table 'ore_lavoro' where the name is equal to the name of an object of type WorkHours.
     * @param WorkHours $workHours The data of the assignment to delete.
     * @return bool true if the deletion is successful, false otherwise.
     */
    public function deleteWorkHours(WorkHours $workHours): bool
    {
        //Check if the work hours to be added to the database are valid
        if ($workHours->isValid()) {

            //Delete a row from table 'ore_lavoro' using inherited function "deleteModel".
            return $this->deleteModel(
                [
                    $workHours->activity->getName(),
                    $workHours->resource->getName(),
                    $workHours->date->format("Y-m-d"),
                    $workHours->hoursNumber]);

        }

        return false;

    }

    /**
     * Checks if the values of the fields of this object of type Assignment are valid.
     * The values are valid when all of the following conditions are true:
     * - the value of fields 'activity', 'resource', 'date' and 'hoursNumber' is not null
     * - the value of field 'hoursNumber' is greater than zero
     * - the call to functions "isValid" of both activity and resource is true
     * - the values of the fields of both activity and resource are equal to those in the row of their respective table
     * whose name is equal to the value of their 'name' field.
     * - the activity and resource are assigned inside table 'assegna' of the database
     * @return bool true if this instance of WorkHours is valid, false otherwise.
     */
    public function isValid(): bool
    {
        if (isset($this->activity) &&
            isset($this->resource) &&
            $this->activity->isValid() &&
            $this->resource->isValid()) {

            $baseAssignment = new Assignment();
            $databaseActivity = $this->activity->getActivityByName($this->activity->getName());
            $databaseResource = $this->resource->getResourceByName($this->resource->getName());

            return
                isset($this->date) &&
                isset($this->hoursNumber) &&
                intval($this->hoursNumber) > 0 &&
                $this->activity->equals($databaseActivity) &&
                $this->resource->equals($databaseResource) &&
                $baseAssignment->isAssigned($this->activity, $this->resource) &&
                $this->date >= $databaseActivity->getStartDate() &&
                $this->date <= $this->activity->getDeliveryDate();

        }

        return false;

    }

}