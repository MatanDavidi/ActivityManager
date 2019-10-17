<?php


class Resource
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
    public function __construct(string $name, float $hourCost)
    {
        $this->name = $name;
        $this->hourCost = $hourCost;
    }


}