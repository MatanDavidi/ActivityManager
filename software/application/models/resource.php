<?php
require_once "application/models/model.php";

class Resource extends Model
{

    /**
     * @var string The name of this resource.
     */
    private $name;

    /**
     * @var float The cost per hour of this resource.
     */
    private $hourCost;

    /**
     * Resource constructor.
     * @param string $name The name of this resource.
     * @param float $hourCost The cost per hour of this resource.
     */
    public function __construct(string $name = null, float $hourCost = null)
    {
        parent::__construct("risorsa", ["nome"]);
        $this->name = $name;
        $this->hourCost = $hourCost;
    }

    /**
     * Get all resources reading their data from the database.
     * @return array An array containing a object of type Resource for each line read from the database.
     */
    public function getAllResources(): array
    {
        //Get the database's data thanks to superclass 'Model'.
        $models = $this->getAllModels();

        //Instantiates the array that will be returned.
        $resources = [];

        // Loop through each element read from the database and for each of them add an object
        // of type Resource with the data from the current element from models to array activities.
        foreach ($models as $model) {

            array_push($resources, new Resource($model["nome"], $model["costo_ora"]));

        }

        return $resources;

    }

}