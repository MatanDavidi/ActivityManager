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
     * @var string The password that this resource uses to login.
     */
    private $password;

    /**
     * @var string The role this resource has in the application.
     */
    private $role;

    /**
     * The valid values that can be set to field role.
     */
    private const ROLE_VALUES = ["amministratore", "utente"];

    /**
     * Resource constructor.
     * @param string $name The name of this resource.
     * @param float $hourCost The cost per hour of this resource.
     * @param string $password The password that this resource uses to login.
     * @param string $role The role this resource has in the application.
     */
    public function __construct(string $name = null, float $hourCost = null, string $password = null, string $role = self::ROLE_VALUES[1])
    {
        parent::__construct("risorsa", ["nome"]);
        $this->name = $name;
        $this->hourCost = $hourCost;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Gets the name of this resource.
     * @return string The name of this resource.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the cost per hour of this resource.
     * @return float The cost per hour of this resource.
     */
    public function getHourCost(): float
    {
        return $this->hourCost;
    }

    /**
     * Gets the role this resource has in the application.
     * @return string The role this resource has in the application.
     */
    public function getRole(): string
    {
        return $this->role;
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

            //Add a new object of type Resource with the model's data to the array
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
        $model = $this->getModelByKey([$name]);

        //If a result has been returned
        if ($model) {

            //Assign to a variable the result's data

            //Return a new object of type Resource with the result's data
            $resource = new Resource($model["nome"], $model["costo_ora"]);
            return $resource;

        }

        //If we got to this point, it means a result was not found, so return null
        return null;

    }

    /**
     * Inserts a new row into table 'risorsa' of database with data passed as parameter.
     * @param Resource $resource An object of type Resource that contains the data to add to the database.
     * @return bool true if the insert operation is successful, false otherwise.
     */
    public function addResource(Resource $resource): bool
    {

        //Check if the resource to be added is set, its name and cost per hour have been set and either
        // both its password and role (with a value that is contained in array ROLE_VALUES) are set or neither.
        if ($this->isValid()) {

            //Crypt password
            $securePassword = password_hash($resource->password, PASSWORD_DEFAULT);

            //Insert a new row into table 'risorsa' using inherited function "addModel".
            return $this->addModel([$resource->name, $resource->hourCost, $securePassword, $resource->role]);

        }

        return false;

    }

    /**
     * Deletes a record from the MySQL table 'risorsa' where the name is equal to the name of an object of type Resource.
     * @param Resource $resource The data of the activity to delete.
     * @return bool true if the deletion is successful, false otherwise.
     */
    public function deleteResource(Resource $resource): bool
    {
        return $this->deleteModel([$resource->name]);
    }

    /**
     * Checks if an object of type Resource's fields have the same value as the fields of this instance of Resource.
     * @param Resource $resource The object against which to compare.
     * @return bool true if the two object's fields have the same value, false otherwise.
     */
    public function equals(Resource $resource)
    {
        return
            $resource->name === $this->name &&
            $resource->hourCost === $this->hourCost &&
            $resource->password === $this->password &&
            $resource->role === $this->role;
    }

    /**
     * Checks if the values of the fields of this object of type Resource are valid.
     * The values are valid when the resource is not null, its name and cost per hour are not null and either
     * both its password and role (with a value that is contained in array ROLE_VALUES) are set or neither.
     * @return bool true if the values of the fields of this object are valid, otherwise false.
     */
    public function isValid(): bool
    {

        return isset($resource) &&
            isset($resource->name) &&
            strlen(trim($resource->name)) > 0 &&
            isset($resource->hourCost) &&
            $resource->hourCost >= 0.0 &&
            (
                (
                    isset($resource->password) &&
                    strlen(trim($resource->password)) > 0 &&
                    isset($resource->role) &&
                    strlen(trim($resource->role)) > 0 &&
                    in_array($resource->role, self::ROLE_VALUES)
                ) ||
                (
                    (
                        !isset($resource->password) ||
                        strlen(trim($resource->password)) == 0
                    ) &&
                    (
                        !isset($resource->role) ||
                        strlen(trim($resource->role)) == 0
                    )
                )
            );

    }

}