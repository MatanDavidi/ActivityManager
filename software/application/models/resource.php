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

    /**
     * Gets a resource with the specified name.
     * @param string $name The name for which to search for a resource in the database.
     * @return Resource An object of type Resource whose fields' values are equal to the data of the
     * line of the database's 'risorse' table whose name corresponds to the value of parameter 'name'.
     */
    public function getResourceByName(string $name): Resource
    {

        //Use function getModelByKey inherited from superclass Model to get a single Resource by its name.
        $models = $this->getModelByKey([$name]);

        //If a result has been returned
        if (isset($models) && count($models) > 0) {

            //Assign to a variable the result's data
            $model = $models[0];

            //Return a new object of type Resource with the result's data
            $resource = new Resource($model["nome"], $model["costo_ora"]);
            return $resource;

        }

        //If we got to this point, it means a result was not found, so return null
        return null;

    }
}