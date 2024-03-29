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
     * The value for the admins' role in table 'risorsa' of the database.
     */
    public const ADMINISTRATOR_ROLE = "amministratore";

    /**
     * The value for the regular users' role in table 'risorsa' of the database.
     */
    public const USER_ROLE = "utente";

    /**
     * The valid values that can be set to field role.
     */
    private const ROLE_VALUES = [self::ADMINISTRATOR_ROLE, self::USER_ROLE];

    /**
     * Resource constructor.
     * @param string $name The name of this resource.
     * @param float $hourCost The cost per hour of this resource.
     * @param string $password The password that this resource uses to login.
     * @param string $role The role this resource has in the application. The default value is "utente".
     */
    public function __construct(string $name = null, float $hourCost = null, ?string $password = null, ?string $role = self::USER_ROLE)
    {
        parent::__construct("risorsa", ["nome"], ["nome", "costo_ora", "password", "ruolo"]);
        $this->name = $name;
        $this->hourCost = $hourCost;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Gets the name of this resource.
     * @return string The name of this resource.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the cost per hour of this resource.
     * @return float The cost per hour of this resource.
     */
    public function getHourCost(): ?float
    {
        return $this->hourCost;
    }

    /**
     * Gets the role this resource has in the application.
     * @return string The role this resource has in the application.
     */
    public function getRole(): ?string
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
     * line of the database's 'risorse' table whose name corresponds to the value of parameter 'name'
     * or NULL if no resource could be found.
     */
    public function getResourceByName(string $name): ?Resource
    {

        //Use function getModelByKey inherited from superclass Model to get a single Resource by its name.
        $model = $this->getModelByKey([$name]);

        //If a result has been returned
        if (isset($model)) {

            //Return a new object of type Resource with the result's data
            $resource = new Resource($model["nome"], $model["costo_ora"], $model["password"], $model["ruolo"]);
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
        if ((!isset($resource->password) || strlen(trim($resource->password)) == 0) &&
            (isset($resource->role) || strlen(trim($resource->role)) > 0)) {
            $resource->role = null;
        }

        //Check if the resource to be added is set, its name and cost per hour have been set and either
        // both its password and role (with a value that is contained in array ROLE_VALUES) are set or neither.
        if ($resource->isValid()) {

            //Crypt password
            $securePassword = password_hash($resource->password, PASSWORD_BCRYPT);

            //Insert a new row into table 'risorsa' using inherited function "addModel".
            return $this->addModel([$resource->name, $resource->hourCost, $securePassword, $resource->role]);

        }

        return false;

    }

    /**
     * Deletes a record from the MySQL table 'risorsa' where the name is equal to the name of an object of type Resource.
     * @param Resource $resource The data of the resource to delete.
     * @return bool true if the deletion is successful, false otherwise.
     */
    public function deleteResource(Resource $resource): bool
    {
        //If the resource is valid and its values are present in a single row of table 'risorsa' of the database, delete.
        if ($resource->isValid()) {
            if ($resource->equals($this->getResourceByName($resource->getName()))) {
                return $this->deleteModel([$resource->name]);
            }
        }
        return false;
    }

    /**
     * Checks if a resource's name and password correspond to those read from the database.
     * @param string $name The name with which to login.
     * @param string $password The password with wich to login.
     * @return bool true if the resource's name and password correspond
     * to those of an existing resource in the database, false otherwise.
     */
    public function login(string $name, string $password): bool
    {
        //Get the resource whose name is equal to parameter name
        $databaseResource = $this->getResourceByName($name);
        //Check if a result was returned
        if (isset($databaseResource)) {
            //Check if the value of parameter 'password' and the hash read from the database correspond
            return password_verify($password, $databaseResource->password);

        }

        //If no result was found, return false
        return false;

    }

    /**
     * Checks if an object of type Resource's fields have the same value as the fields of this instance of Resource.
     * @param Resource $resource The object against which to compare.
     * @return bool true if the two object's fields have the same value, false otherwise.
     * Particularly, the password has to be the same hash.
     */
    public function equals(Resource $resource): bool
    {
        if (isset($resource)) {
            return
                $resource->name === $this->name &&
                $resource->hourCost === $this->hourCost &&
                $resource->password === $this->password &&
                $resource->role === $this->role;
        }
        return false;
    }

    /**
     * Checks if the values of the fields of this object of type Resource are valid.
     * The values are valid when all of the following conditions are true:
     * - the resource is not null
     * - its name and cost per hour are not null
     * - either both its password and role (with a value that is contained in array ROLE_VALUES) are not null or neither.
     * @return bool true if the values of the fields of this object are valid, otherwise false.
     */
    public function isValid(): bool
    {
        return
            isset($this->name) &&
            strlen(trim($this->name)) > 0 &&
            isset($this->hourCost) &&
            $this->hourCost >= 0.0 &&
            (
                (
                    isset($this->password) &&
                    strlen(trim($this->password)) > 0 &&
                    isset($this->role) &&
                    strlen(trim($this->role)) > 0 &&
                    in_array($this->role, self::ROLE_VALUES)
                ) ||
                (
                (
                    is_null($this->role) ||
                    strlen(trim($this->role)) == 0
                )
                )
            );

    }

}