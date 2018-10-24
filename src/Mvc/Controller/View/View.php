<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 13:58
 */
    namespace Mvc\Controller\View;


    class View implements DisplayableInterface, ConfigurableInterface, ArrayAccess {

        private $_templatePath="";
        private $_baseUrl="/";
        private $_aVars=array();

        /**
         * @param string $templatePath
         */
        public function setTemplatePath($templatePath)
        {
            $this->_templatePath = $templatePath;
        }

        /**
         * @param string $baseUrl
         */
        public function setBaseUrl($baseUrl)
        {
            $this->_baseUrl = $baseUrl;
        }

        /**
         * @return string
         */
        public function getTemplatePath()
        {
            return $this->_templatePath;
        }

        /**
         * @return string
         */
        public function getBaseUrl()
        {
            return $this->_baseUrl;
        }


        public function setVar($tab){
            $this->_aVars=$tab;
        }

        public function getVars(){
            return $this->_aVars;
        }

        public function clearVars(){
            $this->_aVars=array();
        }

        public function display($vue){
            if($vue !== null) {
                echo "Vue : $vue";
            }else{
                trigger_error("La vue est inexistante", E_USER_ERROR);
            }
        }

        public function offsetSet($offset, $value) {
            if (is_null($offset)) {
                trigger_error("L'indice n'existe pas", E_USER_ERROR)
            } else {
                $this->_aVars[$offset] = $value;
            }
        }

        public function offsetExists($offset) {
            if (is_null($offset)) {
                trigger_error("L'indice n'existe pas", E_USER_ERROR)
            } else {
                return isset($this->_aVars[$offset]);
            }
        }

        public function offsetUnset($offset) {
            if (is_null($offset)) {
                trigger_error("L'indice n'existe pas", E_USER_ERROR)
            } else {
                unset($this->_aVars[$offset]);
            }
        }

        public function offsetGet($offset) {
            return isset($this->_aVars[$offset]) ? $this->_aVars[$offset] : trigger_error("L'indice n'existe pas", E_USER_ERROR);;
        }

        public function __set($offset, $value){
            $this->offsetSet($offset, $value);
        }

        public function __get($offset){
            $this->offsetGet($offset);
        }

        public function __isset($offset){
            $this->offsetExists($offset);
        }

        public function __unset($offset){
            $this->offsetUnset($offset);
        }

    }

?>
