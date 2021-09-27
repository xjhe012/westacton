<?php
use app\libraries\Database as Database;
    Class TransactionModel extends Database{

        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public function insertTransaction($data)
        {
            $sql = "INSERT INTO `westacton!`.`transaction` 
                    (
                    `player_id`,
                    `description`
                    )
                    VALUES
                    (
                    :player_id,
                    :description
                    );
                ";
                // print_r($data); exit;
            $this->db->query($sql);
            $this->db->bind(":player_id",$data['id'],null);
            $this->db->bind(":description",$data['description'],null);
            $this->db->execute();
            return $this->db->getLastInsertId();
        }
        public function getTransactionBySession($params)
        {
            $sql = "SELECT b.name as player,a.description
                    FROM `transaction`  a
                    inner join `players` b on a.player_id = b.id
                    inner join `gamesession` c on c.player_id = b.id
                    where c.session_name = :session_name
                    order by a.created_at desc";
            $this->db->query($sql);
            $this->db->bind(":session_name",$params,null);
            $result =  $this->db->resultSet();
            return $result;
        }

    }