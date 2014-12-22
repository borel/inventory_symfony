<?php
/**
 * Created by PhpStorm.
 * User: pbborel
 * Date: 13/11/2014
 * Time: 14:59
 */

namespace CZS\UserBundle\Controller;


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods : GET, POST, PUT ,OPTIONS');
header('Access-Control-Allow-Headers :Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With');



use CZS\UserBundle\Entity\Loan;
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
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;
use CZS\UserBundle\Utils\RestClient;

class UserController extends Controller  implements ClassResourceInterface{


    const URL = 'http://api0.cityzendata.net:8080/api/v0/exec/einstein';
    const dateDebut = "'2013-12-11T00:43:00.000Z'\r";
    const dateFin   = "'2015-12-11T19:25:00.000Z'\r";
    const gateway = "'GW1417042'\r"; //
    //const gateway = "'GW1417042'\r";



    /**
     * @QueryParam(name="gw", nullable=true, description="GW de l'utilisateur")
     * @QueryParam(name="dateDebut", nullable=true, description="dateDebut de l'utilisateur")
     * @QueryParam(name="dateFin", nullable=true, description="dateFin de l'utilisateur")
     *
     * @ApiDoc(
     *
     *   resource = true,
     *   section = "User",
     *   description = "WS for Cadence",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *  }
     *)
     */
    public function getSessionAction(ParamFetcher $paramFetcher){
        $class = "'~com.sciences.cityzen.smoozi.*'\r";
        return $this->buildWS($paramFetcher,$class,true);

    }

    /**
     * @QueryParam(name="gw", nullable=true, description="GW de l'utilisateur")
     * @QueryParam(name="dateDebut", nullable=true, description="dateDebut de l'utilisateur")
     * @QueryParam(name="dateFin", nullable=true, description="dateFin de l'utilisateur")
     *
     * @ApiDoc(
     *
     *   resource = true,
     *   section = "User",
     *   description = "WS for Cadence",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *  }
     *)
     */
    public function getCadenceAction(ParamFetcher $paramFetcher){
         $class = "'~com.sciences.cityzen.smoozi.cadence'\r";
        return $this->buildWS($paramFetcher,$class,false);

    }

    /**
     * @QueryParam(name="gw", nullable=true, description="GW de l'utilisateur")
     * @QueryParam(name="dateDebut", nullable=true, description="dateDebut de l'utilisateur")
     * @QueryParam(name="dateFin", nullable=true, description="dateFin de l'utilisateur")
     *
     * @ApiDoc(
     *
     *   resource = true,
     *   section = "User",
     *   description = "WS for heart rate",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *  }
     *)
     */

    public function getEnergyAction(ParamFetcher $paramFetcher)
    {
        $class = "'~com.sciences.cityzen.smoozi.nrj'\r";
        return $this->buildWS($paramFetcher,$class,false);
    }

    /**
     * @QueryParam(name="gw", nullable=true, description="GW de l'utilisateur")
     * @QueryParam(name="dateDebut", nullable=true, description="dateDebut de l'utilisateur")
     * @QueryParam(name="dateFin", nullable=true, description="dateFin de l'utilisateur")
     *
     * @ApiDoc(
     *
     *   resource = true,
     *   section = "User",
     *   description = "WS for heart rate",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *  }
     *)
     */

    public function getHrAction(ParamFetcher $paramFetcher)
    {
        $class = "'~com.sciences.cityzen.smoozi.hr'\r";
        return $this->buildWS($paramFetcher,$class,false);
    }




    /**
     * WS to find long data
     * @param ParamFetcher $paramFetcher
     * @return array
     *
     */
    private function getLongAction(ParamFetcher $paramFetcher){

        $class = "'~com.sciences.cityzen.smoozi.long'\r";

        $longTimeStamp = $this->buildWS($paramFetcher,$class,false);

        foreach ($longTimeStamp as $key => $val) {
            $long[] = $longTimeStamp[$key][1];
        }

        return $long;
    }

    /**
     * WS to find latt data
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    private function getLattAction(ParamFetcher $paramFetcher){

        $class = "'~com.sciences.cityzen.smoozi.latt'\r";

        $lattTimeStamp = $this->buildWS($paramFetcher,$class,false);

        foreach ($lattTimeStamp as $key => $val) {
            $latt[] = $lattTimeStamp[$key][1];
        }

        return $latt;
    }

    /**
     * @QueryParam(name="gw", nullable=true, description="GW de l'utilisateur")
     * @QueryParam(name="dateDebut", nullable=true, description="dateDebut de l'utilisateur")
     * @QueryParam(name="dateFin", nullable=true, description="dateFin de l'utilisateur")
     *
     * @ApiDoc(
     *
     *   resource = true,
     *   section = "User",
     *   description = "WS for gps",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *  }
     *)
     */
    public function getCoordAction(ParamFetcher $paramFetcher){

        $latt  = $this->getLattAction($paramFetcher);
        $long = $this->getLongAction($paramFetcher);

        $latt_cut = array_slice($latt,0,count($long));


        $coord = array();

        for($i = 0; $i< count($latt_cut) ;$i++){

            $tab = array(
                "latt" => $latt_cut[$i],
                "long"    => $long[$i]
            );

            array_push($coord,$tab);
        }

        return $coord;

    }


    /**
     * Private methode for building WS
     * @param ParamFetcher $paramFetcher
     * @param $class
     * @return mixed
     */
    private function buildWS(ParamFetcher $paramFetcher,$class,$allParam)
    {
        $token = "'sj0aRvXuXaECPTS.TDQDCJTzb0cn6bYECavneCbqCDX1AZul8OJC9_jTp0DTcfThfrLNuuPe7H4kBLzrBLSMvnQ5LvANZYx.jum1J8mYWP0oTL0qhYBy.PTnesdEd5dJtLWZAAM_JiM7BGejrDP3oQMNvRp_eq3QziMmqdzAXTVdeJem5KDZKeQUO_8J0NbJphS4fuwSbEGVDZ6LPW.xy7_3SiKOpIVIbxMsqwCxIw.DdhmNqo9rAgmx58ZsGgnrfF_t8QwlIz7'\r";
        $tagGW = "'GW'\r";

        //Récupération des variables
        $gw = $paramFetcher->get('gw');
        $dateDebut = $paramFetcher->get('dateDebut');
        $dateFin = $paramFetcher->get('dateFin');

        // Controle des valeurs
        if (is_null($gw)) {
            $valueTagGW = self::gateway;
        } else {
            $valueTagGW = "'$gw'" . "\r";
        }

        if (is_null($dateDebut)) {
            $dateDebut = self::dateDebut;
        } else {
            $dateDebut = "'$dateDebut'" . "\r";
        }

        if (is_null($dateFin)) {
            $dateFin = self::dateFin;
        } else {
            $dateFin = "'$dateFin'" . "\r";
        }

        $body = $token . "'token'\r" . "STORE\r" . '$token' . "\r" . $class . $tagGW . $valueTagGW . "2 ->MAP\r" . $dateDebut . $dateFin . "5 ->LIST FETCH";

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: text/xml\r\n",
                'content' => $body,
                'timeout' => 60
            )
        );

        $context = stream_context_create($opts);

        $result = file_get_contents(self::URL, false, $context, -1, 14000000);

        //on transforme pour inegration au datavizz
        $result_json = json_decode($result, true);

        if (!$allParam) {
            $result_json_data = $result_json[0][0]['v'];
        }else{
            return $result_json;
        }

        return $result_json_data;
    }



}