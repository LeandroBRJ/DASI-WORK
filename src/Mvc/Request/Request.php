<?php 

	//quand on crie une classe, il faut un namespace, pour permettre d’encapsuler les variables
	namespace src\Mvc\Request;

    /**
     * Class Request represenation de request HTTP
     * @package src\Mvc\Request
     * @author leandro_DA_SILVA
     * @uses exception
     */
	class Request{

        /**
         * constante GET
         */
		const HTTP_GET  = 'GET';
        /**
         * constante POST
         */
		const HTTP_POST = 'POST';


		protected $_controller;  //protected, pour empecher son acces à quelqu’un non autorisé
		protected $_action;       //en PHP : protected permet juste aux membres de classe d’acceder à l’attribut
		protected $_url;
		protected $_baseUrl;
		protected $_aHttpParams; //c'est lui qui va contenir les parametres de get ou post


        /**
         * Request constructor.
         * @throws Exception s'url est vide ou non renseigné
         */
		public function __construct(){
			
			if(!isset($_SERVEUR['REQUEST_URI'])){ // si REQUEST_URI n'est pas renseigné, on déclenche une exception
				throw new Exception("Le request n'est pas renseigné",1);
			}	
			$this->_url = $_SERVEUR['REQUEST_URI'];

			//HTTP_GET pour recevoir $_GET['...'], HTTP_POST pour recevoir $_POST['...']			
			$this->_aHttpParams[self::HTTP_GET] = $_GET[''];
			$this->_aHttpParams[self::HTTP_POST] = $_POST[''];
		}		
		
		
		//methode accesseur (getter)
		public function getController(){
			return $this->_controller;
		}

		//methode accesseur (getter)
		public function getAction(){
			return $this->_action ;
		}

		//methode accesseur (getter)
		public function getUrl(){
			return $this->_url;
		}

		//methode accesseur (getter)
		public function getBaseUrl(){
			return $this->_baseUrl;
		}

		//methode accesseur (getter)
		public function setController($ctrl){
			$this->_controller = $ctrl;
			return $this;
		}

		//methode accesseur (getter)
		public function setAction($ctrl){
			$this->_action = $ctrl;
			return $this;
		}		

		//methode accesseur (getter)
		public function setUrl($ctrl){
			$this->_url = $ctrl;
			return $this;
		}		

		//methode accesseur (getter)
		public function setBaseUrl($ctrl){
			$this->_baseUrl = $ctrl;
			return $this;
		}		

		public  function isPost(){
			if($_SERVEUR['REQUEST_METHOD'] === HTTP_POST ){
				return true;
			}else{
				return false;
			}
		}

		/*
		public  function marcher(){
			echo "Je marche";
		}

		public  function parler(){
			echo "Je parle";
		}

		//methode sans retour
		public fonction  sauter(){
		 echo "sauter";
		}
		*/

	}

?>