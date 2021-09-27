<?php
use app\libraries\Database as Database;
class GameSessionModel extends Database{

    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getActiveSession()
    {
        $sql = "SELECT session_name FROM `gamesession` where status = 0";
        $this->db->query($sql);

        $result =  $this->db->single();
        return $result;
    }

    public function getSessionById($id)
    {
        $sql = "SELECT session_name FROM `gamesession` where id = :id";
        $this->db->query($sql);
        $this->db->bind(":id",$id,null);
        $result =  $this->db->single();
        return $result;
    }

    public function getSessionByplayerId($id)
    {
        $sql = "SELECT session_name FROM `gamesession` where player_id = :id";
        $this->db->query($sql);
        $this->db->bind(":id",$id,null);
        $result =  $this->db->single();
        return $result;
    }

    public function insertGameSession($data)
    {
        if($data['session_name'] ==''){
            $data['session_name'] = md5(uniqid(microtime(true),true));
        }
        $sql = "INSERT INTO `westacton!`.`gamesession` 
                (
                `session_name`,
                `player_id`
                )
                VALUES
                (
                :session_name,
                :player_id
                );
        
            ";
        $this->db->query($sql);
        $this->db->bind(":session_name",$data['session_name'],null);
        $this->db->bind(":player_id",$data['player_id'],null);
        // print_r($this->db); exit;
        $this->db->execute();
        return $this->db->getLastInsertId();
      
    }

    public function updateGameSessionStatus()
    {
        $date = date('Y-m-d H:i:s');
        $sql = "update `westacton!`.`gamesession` 
                set 
                status=1,
                gamestart_time = '$date'
                where status =0
        
            ";
        $this->db->query($sql);
        // print_r($this->db); exit;
        $this->db->execute();
    }

    public function probability($params)
    {
        $jackpot = FALSE;
        $i = 0; 
        $n = $params; 
        $num = mt_rand(0, 100);  
        if($n <= $num){
            $jackpot = TRUE;
        }
        return $jackpot;
    }


}