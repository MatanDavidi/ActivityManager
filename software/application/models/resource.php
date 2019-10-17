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

        $models = $this->getAllModels();
        $resources = [];

        foreach ($models as $model) {

            array_push($resources, new Resource($model["nome"], $model["costo_ora"]));

        }

        return $resources;

    }

}