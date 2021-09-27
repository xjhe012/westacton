<?php
namespace app\services;
use app\models\EnergyModel;
use app\models\PlayerModel;
use app\libraries\Controller;

class EnergyService extends Controller{
    public function __construct()
    {
        $this->PlayerModel = $this->model('PlayerModel');
        $this->EnergyModel = $this->model('EnergyModel');
    }
    public function deductEnergy($id,$energyDeduct,$points_limit)
    {
        $player = $this->PlayerModel->getPlayerById($id);
        if($player['energy'] < $points_limit){
            $new_points = $player['energy'] - $energyDeduct;
            $points = $this->EnergyModel->computePoints($id,$new_points);
            return false;
        }else{
            $new_points = $player['energy'] - $energyDeduct;
            $points = $this->EnergyModel->computePoints($id,$new_points);
            return true;
        }
       
    }   

}