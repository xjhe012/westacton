<?php
namespace app\controllers;
use app\libraries\Controller;
use app\models\Playermodel;
use app\services\GameSessionService;
use app\services\PlayerService;

class Registration extends Controller{
        public function __construct(){
          $this->PlayerModel = $this->model('PlayerModel');
          $this->GameSessionService = new GameSessionService();
          $this->PlayerService = new PlayerService();
        }

        public function index()
        {
            $data['test'] = $this->PlayerModel->getAllPlayer();
            $this->view('registration/index',$data);
        }
        public function register()
        {
          $data['name'] = $_POST['name'];
          $player = $this->PlayerService->createPlayer($data);
          $data['player_id'] = $player;
          $game_session = $this->GameSessionService->createSession($data);        
          header("Status: 200 Success");
          header("Location:../game/?id=".$player);
          exit;
        }
        
}
