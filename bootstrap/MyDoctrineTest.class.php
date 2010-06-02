<?php

class MyDoctrineTest
{
    private $connection;
    
    public function __construct($app, $file = null)
    {
        $configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', true);
        new sfDatabaseManager($configuration);
    }
    
    public function loadData($file = null)
    {
        if($this->connection === null) {
            $this->connection = Doctrine_Manager::connection();
            $this->connection->beginTransaction();
        }
        $fixture = sfConfig::get('sf_test_dir').'/fixtures';
        if($file !== null) {
            $fixture .= "/$file";
        }

        Doctrine::loadData($fixture);
    }
    
    public function rollback() {
        if($this->connection !== null) {
            $this->connection->rollback();
            unset($this->connection);
        }
    }
}
