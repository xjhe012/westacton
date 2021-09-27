<?php
use app\libraries\Database as Database;
    Class EnergyModel extends Database{

        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public function computePoints($id,$points)
        {
            $sql = "update `westacton!`.`players` 
            set 
            energy = :energy
            where id = :id
    
            ";
            $this->db->query($sql);
            $this->db->bind(":energy",$points,null);
            $this->db->bind(":id",$id,null);
            $this->db->execute();
        }
    }