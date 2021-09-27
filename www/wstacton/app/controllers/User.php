<?php
class User extends Controller{
        public function __construct(){
          $this->model = $this->model('UserModel');
        
        }

        public function index()
        {
            $data['test'] = $this->model->getAllPlayer();
            pr($data); exit;
            $this->view('user/index',$data);
        }
        public function about()
        {
            echo "about";
        }
}
?>