<?php
use app\libraries\Database as Database;
    Class PointsModel extends Database{

        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public function updatePoints($id,$points)
        {
            $sql = "update `westacton!`.`players` 
            set 
            points = :points
            where id = :id
    
            ";
            $this->db->query($sql);
            $this->db->bind(":points",$points,null);
            $this->db->bind(":id",$id,null);
            $this->db->execute();
        }
    }