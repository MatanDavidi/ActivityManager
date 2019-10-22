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
        parent::__construct("assegna", ["nome_lavoro", "nome_risorsa"]);
        $this->activity = $activity;
        $this->resource = $resource;
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

            //Add a new object of type Assignment with the model's data to the array.
            array_push($assignments, new Assignment($modelActivity, $modelResource));

        }

        return $assignments;

    }

    /**
     * Checks if an activity and a resource are associated in the database's 'assegna' table.
     * Note: this function should be used with parameters taken from a call to function "getActivityByName" and
     * "getResourceByName" or "getAllActivities" and "getAllResources".
     * @param Activity $activity The activity from which to take the name to check if it is associated to a resource.
     * @param Resource $resource The resource from which to take the name to check if it is associated to an activity.
     * @return bool true if the two names are present on the same row in the table and if the values
     * of the two objects' fields exist in the same row of their respective tables, false otherwise.
     */
    public function isAssigned(Activity $activity, Resource $resource): bool
    {

        //Get the activity's name
        $activityName = $activity->getName();
        //Get the resource's name
        $resourceName = $resource->getName();

        //Get row of table 'assegna' where resource is assigned to activity.
        $model = $this->getModelByKey([$activityName, $resourceName]);

        $isAssigned = false;

        //If a row has been returned
        if ($model) {

            //Get from the database the activity with the same name as activity->getName().
            $databaseActivity = $activity->getActivityByName($activityName);

            //If the values of its fields are the same as the ones of parameter activity
            if ($activity->equals($databaseActivity)) {

                //Get from the database the resource with the same name as resource->getName().
                $databaseResource = $resource->getResourceByName($resourceName);

                //If the values of its fields are the same as the ones of parameter resource
                if ($resource->equals($databaseResource)) {

                    //All values correspond and the resource is actually assigned to the activity
                    $isAssigned = true;

                }

            }

        }

        //If the parameters are equal to their respective database rows, that means the resource is assigned to the activity.
        return $isAssigned;

    }

}