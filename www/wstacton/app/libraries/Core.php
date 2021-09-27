<?php 
namespace app\libraries;

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getUrl();
    
        // print_r( dirname(__FILE__, 2) . '\\controllers\\' . ucwords($url[0]) . '.php' ); 
        // echo file_exists(dirname(__FILE__, 2) . '/controllers/' . ucwords($url[0]) . '.php') ? "yest":"no";  
        // exit;
        //Look in controllers for first value
        if(file_exists(dirname(__FILE__, 2) . '/controllers/' . ucwords($url[0]) . '.php')){
            //if exists, set as controller
            $this->currentController = ucwords($url[0]);
            //Unset 0 index
            unset($url[0]);
        }
    
        //Require the controller
        require_once dirname(__FILE__, 2) . '/controllers/' . $this->currentController . '.php';
    
        //instantiate controller class
        $class = 'app\\controllers\\' . $this->currentController;
        $this->currentController = new $class;
    
     
        if(isset($url[1])){ 
            if(method_exists($this->currentController,$url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }
        //Get Parameters
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController , $this->currentMethod],$this->params);
    }

    public function getUrl()
    {
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            // allow filter variables as string/number
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //Break into array
            $url = explode('/',$url);
            return $url;
        }
    }
}
