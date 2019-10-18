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

}