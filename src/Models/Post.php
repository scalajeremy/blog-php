<?php

class Post {

    private $container;

    public function __constructor($container) {
        
        $this->container = $container;

    }

    public function getAll(){
        $this->container->logger->info('calling all from the db');
        return $this->container->db->prepare('SELECT');
    }

}