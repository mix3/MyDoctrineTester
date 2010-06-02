<?php

class MyDoctrineTest
{
    private $connection;
    
    public function __construct($app, $file = null)
    {
        $configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', true);
        new sfDatabaseManager($configuration);
        
        // DB構築
        exec('./symfony doctrine:drop-db --env=test --no-confirmation');
        exec('./symfony doctrine:build-db --env=test');
        exec('./symfony doctrine:insert-sql --env=test');
        
        $this->connection = Doctrine_Manager::connection();
        $this->loadData($file);
        $this->connection->beginTransaction();
    }

    public function __destruct()
    {
        $this->rollback();
    }

    public function loadData($file = null)
    {
        $fixture = sfConfig::get('sf_test_dir').'/fixtures';
        if($file !== null) {
            $fixture .= "/$file";
        }

        Doctrine::loadData($fixture);
    }
    
    public function getLimeTest($num = null){
        return new lime_test($num);
    }
    
    public function rollback() {
        if($this->connection !== null) {
            $this->connection->rollback();
            unset($this->connection);
        }
    }
}
