<?php
use app\libraries\Database as Database;
    Class PlayerModel extends Database{

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

        public function getPlayerById($id)
        {
            $sql = "SELECT * FROM `players` 
                    where id = :id";
            $this->db->query($sql);
            $this->db->bind(":id",$id,null);
            $result =  $this->db->single();
            return $result;
        }

        public function getPlayerHighestScore($session)
        {
            $sql = "SELECT * 
                    FROM `players` a
                    inner join `gamesession` b on b.player_id = a.id
                    where b.session_name = :name";
            $this->db->query($sql);
            $this->db->bind(":name",$session,null);
            $result =  $this->db->single();
            return $result;
        }

        public function getPlayerInPool()
        {
            $sql = "SELECT b.*
                    FROM `gamesession`  a
                    inner join`players` b on b.id = a.player_id
                    where a.status = 0";
            $this->db->query($sql);
            $result =  $this->db->resultSet();
            return $result;
        }

        public function insertPlayer($data)
        {
           
            $sql = "INSERT INTO `westacton!`.`players` 
                    (
                    `name`
                    )
                    VALUES
                    (
                    :name
                    );
                ";
                // print_r($data); exit;
            $this->db->query($sql);
            $this->db->bind(":name",$data['name'],null);
            // print_r($this->db); exit;
            $this->db->execute();
            return $this->db->getLastInsertId();
        }

        public function updateplayer($data)
        {
           
            $sql = "update  `westacton!`.`players` 
                    set gamesession_id = :gamesession_id
                ";
            $this->db->query($sql);
            $this->db->bind(":gamesession_id",$data,null);
            // print_r($this->db); exit;
            $this->db->execute();
            
        }

        public function getPlayerRanking($params)
        {
            $sql = "SELECT a.*,b.gamestart_time,b.session_name
                    FROM `players`  a
                    inner join `gamesession` b on b.player_id = a.id
                    where b.session_name = :session_name
                    order by a.points";
            $this->db->query($sql);
            $this->db->bind(":session_name",$params,null);
            $result =  $this->db->resultSet();
            return $result;
        }

    }