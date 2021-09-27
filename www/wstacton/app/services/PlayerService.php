<?php
namespace app\services;
use app\models\PlayerModel;
use app\libraries\Controller;

class PlayerService extends Controller{
    public function __construct()
    {

        $this->PlayerModel = $this->model('PlayerModel');
    }
    public function createPlayer($params)
    {
        $insert_data['name'] = $params['name'];
        $player = $this->PlayerModel->insertPlayer($insert_data);
        return $player;
    }
    public function getPlayerById($id)
    {
        $player = $this->PlayerModel->getPlayerById($id);
        return $player;
    }

    public function getPlayerRanking($session_name)
    {
        $player = $this->PlayerModel->getPlayerRanking($session_name);
        return $player;
    }

    public function getPlayerInPool()
    {
        $player = $this->PlayerModel->getPlayerInPool();
        return $player;
    }   
}