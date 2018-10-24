<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 10:48
 */

    namespace Mvc\Http;

    class Reponse{

        protected $_body = null;
        protected $_httpReponseCode = 200;

        /**
         * @return null
         */
        public function getBody()
        {
            return $this->_body;
        }

        /**
         * @param null $body
         */
        public function setBody($body)
        {
            $this->_body = $body;
        }

        /**
         * @return int
         */
        public function getHttpReponseCode()
        {
            return $this->_httpReponseCode;
        }

        public function clear(){
            $this->_body=null;
            return $this;
        }

        public function sendHeaders(){
            return header("HTTP/1.1" . $this->_httpReponseCode);
        }

        public function send(){
            $this->sendHeaders();
            echo $this->_body;
        }

    }
