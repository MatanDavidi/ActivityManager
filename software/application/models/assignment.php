<?php
require_once "application/models/model.php";
require_once "application/models/activity.php";
require_once "application/models/resource.php";

class Assignment extends Model
{

    /**
     * @var Activity The activity to which the resource is assigned.
     */
    private $activity;

    /**
     * @var Resource The resource assigned to the activity.
     */
    private $resource;

    /**
     * Assignment constructor.
     * @param Activity $activity The activity to which the resource is assigned.
     * @param Resource $resource The resource assigned to the activity.
     */
    public function __construct(Activity $activity = null, Resource $resource = null)
    {
        parent::__construct("assegna", ["nome_lavoro", "nome_risorsa"], ["nome_lavoro", "nome_risorsa"]);
        $this->activity = $activity;
        $this->resource = $resource;
    }

    /**
     * Gets the activity to which the resource is assigned.
     * @return Activity The activity to which the resource is assigned.
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * Gets the resource assigned to the activity.
     * @return Resource The resource assigned to the activity.
     */
    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    /**
     * Get all assignments reading their data from the database.
     * @return array An array containing a object of type Assignment for each line read from the database.
     */
    public function getAllAssignments(): array
    {
        //Instantiates the array that will be returned.
        $assignments = [];

        //Get the database's data thanks to superclass 'Model'.
        $models = $this->getAllModels();

        //Instantiate an empty object of type Activity to use its methods
        $baseActivity = new Activity();

        //Instantiate an empty object of type Resource to use its methods
        $baseResource = new Resource();

        // Loop through each element read from the database and for each of them add an object of
        // type Assignment with the data from the current element from models to array activities.
        foreach ($models as $model) {

            //Get the activity with the same name as the current model.
            $modelActivity = $baseActivity->getActivityByName($model["nome_lavoro"]);
            //Get the resource with the same name as the current model.
            $modelResource = $baseResource->getResourceByName($model["nome_risorsa"]);

            //Only if both the model's activity and resource are not null, can we add the element to the array
            if (isset($modelActivity) &&
                isset($modelResource)) {
                //Add a new object of type Assignment with the model's data to the array.
                array_push($assignments, new Assignment($modelActivity, $modelResource));
            }

        }

        return $assignments;

    }

    /**
     * Gets all activities assigned to a resource by reading them from table 'assegna' of the database.
     * @param Resource $resource The resource to which the activities have to be assigned.
     * @return array An array containing an object of type Activity for each activity to which the resource is assigned the resource.
     */
    public function getActivitiesAssignedToResource(Resource $resource): array
    {
        //Initialize the returned array
        $assignments = [];

        if (!is_null($this->database)) {

            //Check if the resource is valid
            if ($resource->isValid()) {

                //Save to a variable the resource's name
                $resourceName = $resource->getName();
                //Write the query
                $query = "SELECT nome_lavoro FROM assegna WHERE nome_risorsa = :resource";
                //Prepare the query's statement
                $statement = $this->database->prepare($query);
                //Bind placeholder ":resource" to the resource's name
                $statement->bindParam(":resource", $resourceName);
                //If the statement's execution was successful
                if ($statement->execute()) {

                    //Create empty activity to use its functions
                    $baseActivity = new Activity();
                    //Fetch the statement's execution's results
                    $results = $statement->fetchAll(PDO::FETCH_NUM);

                    //Loop through all results
                    foreach ($results as $result) {

                        //Get the activity with the same name as the current result
                        $activity = $baseActivity->getActivityByName($result[0]);
                        //Add the resource to the array
                        array_push($assignments, $activity);

                    }

                }

            }

        }

        return $assignments;
    }

    /**
     * Gets all resources assigned to an activity by reading them from table 'assegna' of the database.
     * @param Activity $activity The activity to which the resources have to be assigned.
     * @return array An array containing an object of type Resource for each resource that's assigned to the activity.
     */
    public function getResourcesAssignedToActivity(Activity $activity): array
    {
        //Initialize the returned array
        $resources = [];

        if (!is_null($this->database)) {

            //Check if the activity is valid
            if ($activity->isValid()) {

                //Save to a variable the activity's name
                $activityName = $activity->getName();
                //Write the query
                $query = "SELECT nome_risorsa FROM assegna WHERE nome_lavoro = :activity";
                //Prepare the query's statement
                $statement = $this->database->prepare($query);
                //Bind placeholder ":activity" to the activity's name
                $statement->bindParam(":activity", $activityName);
                //If the statement's execution was successful
                if ($statement->execute()) {

                    //Create empty resource to use its functions
                    $baseResource = new Resource();
                    //Fetch the statement's execution's results
                    $results = $statement->fetchAll(PDO::FETCH_NUM);

                    //Loop through all results
                    foreach ($results as $result) {

                        //Get the resource with the same name as the current result
                        $resource = $baseResource->getResourceByName($result[0]);

                        //Add the resource to the array
                        array_push($resources, $resource);

                    }

                }

            }

        }

        return $resources;
    }

    /**
     * Checks if an activity and a resource are associated in the database's 'assegna' table.
     * Note: this function should be used with parameters taken from a call to function "getActivityByName" and
     * "getResourceByName" or "getAllActivities" and "getAllResources".
     * @param Activity $activity The activity from which to take the name to check if it is associated to a resource.
     * @param Resource $resource The resource from which to take the name to check if it is associated to an activity.
     * @return bool true if the two names are present on the same row in the table, false otherwise.
     */
    public function isAssigned(Activity $activity, Resource $resource): bool
    {
        //Check if activity and resource are valid
        if ($activity->isValid() &&
            $resource->isValid()) {

            //Get the activity's name
            $activityName = $activity->getName();
            //Get the resource's name
            $resourceName = $resource->getName();

            //Get row of table 'assegna' where resource is assigned to activity.
            $model = $this->getModelByKey([$activityName, $resourceName]);

            //If a row has been returned, that means that the activity and resource exist on same row of table 'assegna'
            return isset($model);

        }

        return false;

    }

    /**
     * Inserts a new row into table 'assegna' of database with data passed as parameter.
     * @param Assignment $assignment An object of type Assignment that contains the data to add to the database.
     * @return bool true if the insert operation is successful, false otherwise.
     */
    public function addAssignment(Assignment $assignment): bool
    {
        //Check if the assignment and its values (Activity and Resource) are not null, this includes all fields of both
        //the assignment's activity and resource.
        //Also, check if the values of the fields of both activity and resource are present in a single row of the database.
        if ($assignment->isValid()) {

            //Insert a new row into table 'assegna' using inherited function "addModel".
            return $this->addModel([$assignment->activity->getName(), $assignment->resource->getName()]);

        }
        return false;
    }

    /**
     * Deletes a record from the MySQL table 'assegna' where the name is equal to the name of an object of type Assignment.
     * @param Assignment $assignment The data of the assignment to delete.
     * @return bool true if the deletion is successful, false otherwise.
     */
    public function deleteAssignment(Assignment $assignment): bool
    {
        //If the assignment is valid and its values are present in a single row of table 'assegna' of the database, delete.
        if ($assignment->isValid()) {

            //Delete a row from table 'assegna' using inherited function "deleteModel".
            return $this->deleteModel([$assignment->activity->getName(), $assignment->resource->getName()]);

        }
        return false;
    }

    /**
     * Checks if the values of the fields of this object of type Assignment are valid.
     * The values are valid when this object is not null and the value that was returned from the call to functions
     * isValid of this assignment's activity and resource is true. Also, the values of both fields have to be present in
     * a single row of their respective tables for this object to be valid.
     * @return bool true if the values of the fields of this object are valid, otherwise false.
     */
    public function isValid()
    {
        if (isset($this->activity) &&
            isset($this->resource) &&
            $this->activity->isValid() &&
            $this->resource->isValid()) {

            $databaseActivity = $this->activity->getActivityByName($this->activity->getName());
            $databaseResource = $this->resource->getResourceByName($this->resource->getName());

            return
                $this->activity->equals($databaseActivity) &&
                $this->resource->equals($databaseResource);

        }

        return false;
    }

}