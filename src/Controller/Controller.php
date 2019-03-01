<?php
namespace App\Controller;


use Psr\Container\ContainerInterface;

class Controller{

    private $container;

    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /**
     * This method allows your to call all the dependencies directly from the $this instance
     * @param $dep
     * @return mixed
     */
    public function __get($dep){
        return $this->container->get($dep);
    }
}