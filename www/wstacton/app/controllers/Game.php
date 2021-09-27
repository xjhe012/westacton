<?php
namespace app\controllers;
use app\libraries\Controller;
use app\models\Playermodel;
use app\models\Pointsmodel;
use app\models\Transactionmodel;
use app\services\PlayerService;
use app\services\GameSessionService;
use app\services\PointsService;
use app\services\EnergyService;
class Game extends Controller{
        public function __construct()
        {
          $this->PlayerModel = $this->model('PlayerModel');
          $this->PlayerService = new PlayerService();
          $this->GameSessionService = new GameSessionService();
          $this->PointsService = new PointsService();
          $this->EnergyService = new EnergyService();
        }

        public function index()
        {
          $data['me'] = $this->PlayerService->getPlayerById($_GET['id']);
          $data['pool'] = $this->PlayerService->getPlayerInPool();
          $this->view('game/index',$data);
        }

        public function gameStart()
        {
          $data['player']= $this->PlayerService->getPlayerById($_GET['id']);
          $data['ranking'] = $this->PlayerService->getPlayerRanking($_GET['session']);
          $data['transaction'] = $this->GameSessionService->getTransactionBySession($_GET['session']);
          $this->view('game/start',$data);
        }

        public function gameEnd()
        {
          $data['ranking'] = $this->GameSessionService->gameWinner($_GET['session']);
          $this->view('game/end',$data);
        }


        public function startSessionGame()
        {
          $this->GameSessionService->updateGameSessionStatus();
          echo json_encode(true);
        }

        public function getActiveSession()
        {
          $data = $this->GameSessionService->getActiveSession();
          echo json_encode($data);
        }

        public function getPlayerSession()
        { 
          $id = $_GET['id'];
          $data = $this->GameSessionService->getSessionById($id);
          echo json_encode($data);
        }

        public function gainPoints()
        {

          $energy = $this->EnergyService->deductEnergy($_POST['id'],8,8);
          $probability = $this->GameSessionService->getProbability(50);
          if($energy){
            if($probability){
              $data['id'] = $_POST['id'];
              $data['description'] = 'Gain Bonus Effect';
              $transaction_curser = $this->GameSessionService->LogTransaction($data);
            }

            $data = $this->PointsService->updatePoint($_POST['id']);
            $data['id'] = $_POST['id'];
            $data['description'] = 'Gain 100 Points';
            $transaction_curser = $this->GameSessionService->LogTransaction($data);
            echo json_encode('Successfully gained 100 points');
          }else{
            echo json_encode('Energy not enough.');
          }
        }

        public function refreshPlayerPool()
        {
          $data = $this->PlayerService->getPlayerInPool();
          echo json_encode($data);
        }
        

        public function reLoadPoints()
        {
          $data= $this->PlayerService->getPlayerRanking($_GET['session']);
          echo json_encode($data);
        }

        public function reLoadTransaction()
        {
          $data= $this->GameSessionService->getTransactionBySession($_GET['session']);
          echo json_encode($data);
        }

        public function cursePlayer()
        {
          
          $energy = $this->EnergyService->deductEnergy($_POST['curser_id'],10,10);
          $probability = $this->GameSessionService->getProbability(25);
          if($energy){
            //deduct points to cursed player
            $data = $this->PointsService->deductPoints($_POST['id']);
            //format the data variable to pass to log transaction
            if($probability){
              $data['id'] = $_POST['id'];
              $data['description'] = 'Cursed';
              $transaction_curser = $this->GameSessionService->LogTransaction($data);
              unset($data);
            }
         
            $data['id'] = $_POST['curser_id'];
            $data['description'] = 'Use Curse';
            $transaction_curser = $this->GameSessionService->LogTransaction($data);
            echo json_encode('Successfully deduct player points');
          }else{
            echo json_encode('Energy not enough.');
          }
        }
 
        
}
