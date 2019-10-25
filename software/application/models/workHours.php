<?php
require_once "application/models/model.php";
require_once "application/models/activity.php";
require_once "application/models/resource.php";

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
                //Add a new object of type Assignment with the model's data to the array.
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

}