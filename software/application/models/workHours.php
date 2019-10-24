<?php
require_once "application/models/model.php";
require_once "application/models/activity.php";
require_once "application/models/resource.php";

class WorkHours extends Model
{

    /**
     * @var Activity The activity for which the resource has worked.
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
        parent::__construct("ore_lavoro", ["nome_lavoro", "nome_risorsa"], ["nome_lavoro", "nome_risorsa", "data", "numero_ore"]);
        $this->activity = $activity;
        $this->resource = $resource;
        $this->date = $date;
        $this->hoursNumber = $hoursNumber;
    }


}