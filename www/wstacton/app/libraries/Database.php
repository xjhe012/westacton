<?php 

    class Database{
        private $dbHost = 'database';
        private $dbUser = 'root';
        private $dbPass = 'westacton!';
        private $dbName = 'westacton!';
        private $port = '3306';

        private $statement;
        private $dbHandler;
        private $error;

        public function __construct()
        {
            $conn ='mysql:host=' .$this->dbHost.';dbname='. $this->dbName.';port='.$this->port;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try{
                $this->dbHandler = new PDO($conn,$this->dbUser,$this->dbPass,$options);
            }catch(PDOException $e){
                $this->error  = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql)
        {
            $this->statement = $this->dbHandler->prepare($sql);
        }

        public function bind($parameter,$vaue,$type = null)
        {
            switch(is_null($type)){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            $this->statement->bindValue($parameter,$value,$type);
        }

        public function execute()
        {
            return $this->statement->execute();
        }

        public function resultSet()
        {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

        public function single()
        {
            $this->execute();
            return $this->statment->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount()
        {
            return $this->statement->rowCount();
        }
    }