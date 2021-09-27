<?php
namespace app\services;
use app\models\PointsModel;
use app\models\PlayerModel;
use app\libraries\Controller;
use app\Services\GameSessionService;
class PointsService extends Controller{
    public function __construct()
    {
        $this->PlayerModel = $this->model('PlayerModel');
        $this->PointsModel = $this->model('PointsModel');
        $this->GameSessionService = new GameSessionService();
    }
    public function updatePoint($id)
    {
        $player = $this->PlayerModel->getPlayerById($id);
        $new_points = $player['points'] + 100;
        $points = $this->PointsModel->updatePoints($id,$new_points);
        return $points;
    }

    public function deductPoints($id)
    {
        $player = $this->PlayerModel->getPlayerById($id);
        $new_points = $player['points'] - 100;
        $points = $this->PointsModel->updatePoints($id,$new_points);
        $data['id'] = $id;
        $data['description'] = 'Deduct 100 points';
        $this->GameSessionService->LogTransaction($data);
        return $points; 
    }

}