<?php
//quand on crie une classe, il faut un namespace, pour permettre d’encapsuler les variables
namespace src\Mvc\Request;

/**
 * Class Request represenation de request HTTP
 * @package src\Mvc\Request
 * @author leandro_DA_SILVA
 * @uses exception
 */
class Request
{

    /**
     * constante GET
     */
    const HTTP_GET = 'GET';
    /**
     * constante POST
     */
    const HTTP_POST = 'POST';


    protected $_controller;  //protected, pour empecher son acces à quelqu’un non autorisé
    protected $_action;       //en PHP : protected permet juste aux membres de classe d’acceder à l’attribut
    protected $_url;
    protected $_baseUrl;
    protected $_aHttpParams = array(); //c'est lui qui va contenir les parametres de get ou post


    /**
     * Request constructor.
     * @throws Exception s'url est vide ou non renseigné
     */
    public function __construct()
    {

        if (!isset($_SERVER['REQUEST_URI'])) { // si REQUEST_URI n'est pas renseigné, on déclenche une exception
            throw new Exception("Le request n'est pas renseigné", 1);
        }
        $this->_url=$_SERVER['REQUEST_URI'];
        $this->_aHttpParams[self::HTTP_GET] = $_GET[''];
        $this->_aHttpParams[self::HTTP_POST] = $_POST[''];
    }


    /**
     * Methode accesseur
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Methode accesseur
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action ;
    }

    /**
     * Methode accesseur
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Methode accesseur
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }

    /**
     * Récupère un paramètre ou l'ensemble des paramètres
     *
     * @param string $sHttpParam (type de superglobale)
     * @param string optional $sKey (si pas de clé passé la superglobale est récupérée dans sa totalité)
     * @param string optional $sDefaultValue
     *
     * @return string
     */
    private function _getHttpParams($sHttpParam, $sKey = null, $sDefaultValue = null)
    {
        //on verifie si la $key existe dans le tableau $sHttpParam. Si oui, retourne le contenu de l'indice $key
        if (null === $sKey) {
            return $this->_aHttpParams[$sHttpParam];
        }

        //si $this->_aHttpParams[$sHttpParam][$sKey] est renseigné, alors retourne son valeur, sinon retourne le valeur de $sDefaultValue
        return (isset($this->_aHttpParams[$sHttpParam][$sKey])) ? $this->_aHttpParams[$sHttpParam][$sKey] : $sDefaultValue;
    }


    /**
     * Methode modificateur
     * @return mixed
     */
    public function setController($ctrl)
    {
        $this->_controller = $ctrl;
        return $this;
    }

    /**
     * Methode modificateur
     * @return mixed
     */
    public function setAction($ctrl)
    {
        $this->_action = $ctrl;
        return $this;
    }

    /**
     * Methode modificateur
     * @return mixed
     */
    public function setUrl($ctrl)
    {
        $this->_url = $ctrl;
        return $this;
    }

    /**
     * Methode modificateur
     * @return mixed
     */
    public function setBaseUrl($ctrl)
    {
        $this->_baseUrl = $ctrl;
        return $this;
    }

    /**
     * Methode pour vérifier si le request c'est POST
     * @return bool si c'est POST ou pas
     */
    public function isPost()
    {
        if($_SERVER['REQUEST_METHOD'] === HTTP_POST) {
            return true;
        } else {
            return false;
        }
    }


    public function __call($sMethod, array $aArgs)
    {
        /*
         * Récupère les arguments
         */
        $sKey = null;
        $sValue = null;

        if (isset($aArgs[0])) {
            $sKey = $aArgs[0];
        }
        if (isset($aArgs[1])) {
            $sValue = $aArgs[1];
        }

        /*
         * Récupère l'action et le paramètre
         */
        $sAction = strtolower(substr($sMethod, 0, 3));//recupere les trois premiers indices de la string
        $sHttpParam = strtoupper(substr($sMethod, 3));//on recuperer les derniers indices de la string, exclus les trois premiers

        /*
         * Appelle la bonne méthode
         */
        if ('get' === $sAction) {//si premier parametre est get
            switch ($sHttpParam) {
                case self::HTTP_GET : //si deuxieme parametre est GET
                case self::HTTP_POST : //si POST, on entre dans l'autre switch
                    return $this->{'_getHttpParams'}($sHttpParam, $sKey, $sValue); //on appelle la fonction en passant en parametre le nom de la fonction
                    break;
                default :
                    throw new Request\Exception("Type de superglobale ($sHttpParam) non géré");
            }
        }

        throw new Request\Exception('Méthode inconnue');
    }

}

?>