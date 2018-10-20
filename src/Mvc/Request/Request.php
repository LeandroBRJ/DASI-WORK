<?php 

	//quand on crie une classe, il faut un namespace, pour permettre d’encapsuler les variables
	namespace src\Mvc\Request;
	

	class Request{

		//declarer une constante
		const NIVEAU_AMATEUR = 1;

		//les proprietes
		protected $_controller;  //protected, pour empecher son acces à quelqu’un non autorisé
		protected $_action;       //en PHP : protected permet juste aux membres de classe d’acceder à l’attribut
		protected $_url;
		protected $_baseUrl;

		
		//constructeur de la classe
		//$arme c'est un objet de la classe Arme
		public function __construct($_SERVEUR['REQUEST_URI']){
			
			if(! isset($_SERVEUR['REQUEST_URI'])){ // si REQUEST_URI n'est pas renseigné, on déclenche une exception
				throw new Exception("Le request n'est pas renseigné", 1);				
			}	
			$this -> _url = $_SERVEUR['REQUEST_URI'];
		}		
		
		
		//methode accesseur (getter)
		public function getController(){
			return $this -> _controller ;
		}

		//methode accesseur (getter)
		public function getAction(){
			return $this -> _action ;
		}

		//methode accesseur (getter)
		public function getUrl(){
			return $this -> _url;
		}

		//methode accesseur (getter)
		public function getBaseUrl(){
			return $this -> _baseUrl;
		}

		//methode accesseur (getter)
		public function setController($ctrl){
			$this -> _controller = $ctrl ;
			return $this ;	
		}

		//methode accesseur (getter)
		public function setAction($ctrl){
			$this -> _action = $ctrl ;
			return $this ;	
		}		

		//methode accesseur (getter)
		public function setUrl($ctrl){
			$this -> _url = $ctrl ;
			return $this ;	
		}		

		//methode accesseur (getter)
		public function setBaseUrl($ctrl){
			$this -> _baseUrl = $ctrl ;
			return $this ;	
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