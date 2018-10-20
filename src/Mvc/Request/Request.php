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

			$this->_aHttpParams[self::HTTP_GET] = $_GET[''];
			$this->_aHttpParams[self::HTTP_POST] = $_POST[''];
		}


        /**
         * Methode accesseur
         * @return mixed
         */
		public function getController(){
			return $this->_controller;
		}

        /**
         * Methode accesseur
         * @return mixed
         */
		public function getAction(){
			return $this->_action ;
		}

        /**
         * Methode accesseur
         * @return mixed
         */
		public function getUrl(){
			return $this->_url;
		}

        /**
         * Methode accesseur
         * @return mixed
         */
		public function getBaseUrl(){
			return $this->_baseUrl;
		}

        /**
         * Methode modificateur
         * @return mixed
         */
		public function setController($ctrl){
			$this->_controller = $ctrl;
			return $this;
		}

        /**
         * Methode modificateur
         * @return mixed
         */
		public function setAction($ctrl){
			$this->_action = $ctrl;
			return $this;
		}

        /**
         * Methode modificateur
         * @return mixed
         */
		public function setUrl($ctrl){
			$this->_url = $ctrl;
			return $this;
		}

        /**
         * Methode modificateur
         * @return mixed
         */
		public function setBaseUrl($ctrl){
			$this->_baseUrl = $ctrl;
			return $this;
		}

        /**
         * Methode pour vérifier si le request c'est POST
         * @return bool si c'est POST ou pas
         */
		public  function isPost(){
			if($_SERVEUR['REQUEST_METHOD'] === HTTP_POST ){
				return true;
			}else{
				return false;
			}
		}

	}

?>