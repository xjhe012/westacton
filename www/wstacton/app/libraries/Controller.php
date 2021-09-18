<?php 

    class Controller{

        public function model($model)
        {
            require_once '../app/models/' .$model.'.php';
            return new $model();
        }

        public function view($view, $data= [])
        {
            if(file_exists('../app/views/'.$view.'.php')){
                require_once ('../app/views/'.$view.'.php');
            }else{

            }
        }
        
        public function pr($data)
        {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }

    }