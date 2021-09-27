<?php
namespace app\services;
use app\models\GameSessionModel;
use app\models\TransactionModel;
use app\models\PlayerModel;
use app\libraries\Controller;
class GameSessionService extends Controller{
    public function __construct(){
        $this->model = $this->model('GameSessionModel');
        $this->Transactionmodel = $this->model('TransactionModel');
        $this->PlayerModel = $this->model('PlayerModel');
    }
    public function createSession($params)
    {
        $session_data = $this->model->getActiveSession(); 
        if(empty($session_data)){
            $params['session_name'] = '';
            $session_id = $this->model->insertGameSession($params);
            return $this->model->getSessionById($session_id);
        }else{
            $params['session_name'] = $session_data['session_name'];
            $session_id = $this->model->insertGameSession($params);
        }

        
    }

    public function updateGameSessionStatus()
    {
        $session_id = $this->model->updateGameSessionStatus();
    }

    public function getActiveSession()
    {
        $session_id = $this->model->getActiveSession(); 
        return $session_id;
    }
    public function getSessionById($id)
    {
      
        $session_id = $this->model->getSessionByplayerId($id); 
        return $session_id;
    }

    public function getProbability($params)
    {
        $bool = $this->model->probability($params); 
        return $bool;
    }

    public function LogTransaction($data)
    {
        $this->Transactionmodel->insertTransaction($data); 
    }

    public function getTransactionBySession($session)
    {
        return $this->Transactionmodel->getTransactionBySession($session); 
    }

    public function gameWinner($session)
    {
        return $this->PlayerModel->getPlayerHighestScore($session); 
    }
  
}