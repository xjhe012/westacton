<?php
    Class UserModel{

        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public function getAllPlayer()
        {
            $sql = "SELECT * FROM `players`";
            $this->db->query($sql);

            $result =  $this->db->resultSet();
            return $result;
        }

    }