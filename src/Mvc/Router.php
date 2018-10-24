<?php
/**
 * Created by PhpStorm.
 * User: leandro_da_silva
 * Date: 24/10/18
 * Time: 11:34
 */
    namespace Mvc;

    //c'est necessaire pour prendre en compte un fichier qui n'est pas dans le meme namespace
    use \Mvc\Router\RoutableInterface;


    require_once 'Router/RoutableInterface.php';

    class Router implements RoutableInterface{
        //pour supprimer les / de la chaîne de la requete
        const URL_SEPARATOR = "/";

        public function route(\Mvc\Http\Request $request){
            //supprime les espaces et les / de la string
            $url = trim($request->getUrl(), self::URL_SEPARATOR);

            if($url != ''){
                //-------suppression de la partie GET---------
                //si il y a un char ?, on recupere sa position dans la chaine
                if(false !==$iPos = strpos($url, '?')){
                    //on supprime la partie GET
                    $url=substr($url,0,$iPos);
                }

                //---------supprime l'url de la base--------
                $url=trim(
                    //suppression de l'url
                    str_replace(
                      trim($request->getBaseUrl(),self::URL_SEPARATOR),
                        '',
                        $url
                    ),
                    self::URL_SEPARATOR
                );

                //---------sépare le controleur et l'action
                //explode pour couper la string en segments
                $url = explode(self::URL_SEPARATOR,$url);

                //---------propagation du controleur à l'objet requête
                //si le tableau n'est pas vide
                if(!empty($url[0])){
                    //on dépile le premier indice (on le récupere puis on le supprime)
                    $request->setController(array_shift($url));
                    //-------------propagation de l'action à l'objet requete
                    //si le deuxieme indice du tableau original n'est pas null, on dépile (on le récupere puis on le supprime)
                    if(!empty($url[0])){
                        $request->setAction(array_shift($url));
                    }
                }
            }

            return $this;

        }
    }

?>