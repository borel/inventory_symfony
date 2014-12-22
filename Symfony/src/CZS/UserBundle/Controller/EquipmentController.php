<?php
/**
 * Created by PhpStorm.
 * User: pbborel
 * Date: 14/11/2014
 * Time: 15:45
 */

namespace CZS\UserBundle\Controller;


namespace CZS\UserBundle\Controller;

header('Access-Control-Allow-Origin: *');

use CZS\UserBundle\Entity\Equipment;
use CZS\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\DBALException;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Exception;


class EquipmentController extends Controller  implements ClassResourceInterface{

    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "Equipment",
     *   description = "Equipment create",
     *   statusCodes = {
     *     401 = "Database exception",
     *     200 = "Equipment is create"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *      {"name"="size", "dataType"="string","description"="size"},
     *      {"name"="version", "dataType"="string","description"="version"},
     *      {"name"="id_czs", "dataType"="string",  "description"="id_czs"},
     *      {"name"="description", "dataType"="string",  "description"="description"},
     *      {"name"="content", "dataType"="string",  "description"="content"},
     *      {"name"="type", "dataType"="string", "description"="type"},
     *  }
     * )
     */
    public function postNewAction(Request $request)
    {
        $response = new Response();


        try {
            $equipment = new Equipment();
            $equipment->bind($request);

            //On persiste
            $this->getDoctrine()->getManager()->persist($equipment);
            $this->getDoctrine()->getManager()->flush();

            //On renvoie la réponse si ok
            $response->setContent($equipment->getId());
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/html');
        }catch (\Exception $e){
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);
            $response->headers->set('Content-Type', 'text/html');
        }

        // affiche les entêtes HTTP suivies du contenu
        $response->send();
    }


    /**
     * @QueryParam(name="id_czs", nullable=true, description="Identifiant CZS de l'equipement")
     * @QueryParam(name="size", nullable=true, description="Taille de l'equipement")
     * @QueryParam(name="version", nullable=true, description="Version de l'equipement")
     * @QueryParam(name="type", nullable=true, description="Type de l'equipement")
     * @QueryParam(name="userId", nullable=true, description="Utilisateur de l'equipment")
     * @ApiDoc(
     *   resource = true,
     *   section = "Equipment",
     *   description = "Recherche des equipments",
     *   statusCodes = {
     *     401 = "Erreur dans les paramétres présent"
     *   },
     *   tags={
     *      "stable"
     *   }
     * )
     * @param ParamFetcher $paramFetcher
     */
    public function getFindAction(ParamFetcher $paramFetcher)
    {

        $repository = $this->getDoctrine()->getRepository('CZSUserBundle:Equipment');
        $equipments = array();

        try{
            $id_czs = $paramFetcher->get('id_czs');
            $size = $paramFetcher->get('size');
            $version = $paramFetcher->get('version');
            $type = $paramFetcher->get('type');
            $userId = $paramFetcher->get('userId');

            //Construction du tableau de réponse
            $criterias = array();
            if(!is_null($id_czs)){
                $criterias["id_czs"] = $id_czs;
            }

            if(!is_null($size)){
                $criterias["size"] = $size;
            }

            if(!is_null($version)){
                $criterias["version"] = $version;
            }

            if(!is_null($type)){
                $criterias["type"] = $type;
            }

            if(!is_null($userId)){
                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->findUserBy( array("id"=> $userId));
                $criterias["user"] = $user;
            }

            $equipments = $repository->findBy($criterias);

        }catch (\Exception $e){

        }
         return $equipments;
    }
} 