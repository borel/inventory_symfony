<?php

namespace CZS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {

        $name = 'borel';
        return $this->render('CZSUserBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "Recherche de tous les utilisateurs",
     *   statusCodes = {
     *     400 = "Erreur"
     *   },
     *  tags={
     *      "stable"
     *  }
     * )
     *
     */
    public function getAllAction(){
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $users;
    }

    /**
     * @QueryParam(name="email", nullable=true, description="Email de l'utilisateur")
     * @QueryParam(name="username", nullable=true, description="Username de l'utilisateur")
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "Recherche d'un utilisateur",
     *   statusCodes = {
     *     401 = "Le nom ou le mail doit être présent"
     *   },
     *   tags={
     *      "stable"
     *   }
     * )
     * @param ParamFetcher $paramFetcher
     */
    public function getFindAction(ParamFetcher $paramFetcher)
    {
        $userManager = $this->get('fos_user.user_manager');

        $email = $paramFetcher->get('email');
        $username = $paramFetcher->get('username');

        if(is_null($email) && is_null($username)) {
            throw new HttpException(401, "Le nom ou le mail doit être renseigné");
        }

        if (!is_null($email)) {
            $user = $userManager->findUserByEmail($email);
        }else{
            $user = $userManager->findUserByUsername($username);
        }

        return $user;
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "User create",
     *   statusCodes = {
     *     401 = "Database exception",
     *     200 = "User is create"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *      {"name"="username", "dataType"="string", "required"=true, "description"="username"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="email"},
     *
     *  }
     * )
     */
    public function postNewAction(Request $request)
    {

        $response = new Response();

        //On récupére les infos du $request
        $email = $request->get('email');
        $username = $request->get('username');

        try {
            $user = new User();
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPassword('default');

            //On persiste
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            //On renvoie la réponse si ok
            $response->setContent($user->getId());
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/html');

        }catch (DBALException $e){
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);
            $response->headers->set('Content-Type', 'text/html');
        }

        // affiche les entêtes HTTP suivies du contenu
        $response->send();

    }


    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "User update",
     *   statusCodes = {
     *     401 = "Database exception",
     *     200 = "User is create"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *      {"name"="username", "dataType"="string", "description"="username"},
     *      {"name"="email", "dataType"="string", "description"="email"},
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id"},
     *
     *  }
     * )
     */
    public function  postUpdateAction(Request $request){

        $response = new Response();

        //On récupére les infos du $request
        $email = $request->get('email');
        $username = $request->get('username');
        $idUser = $request->get('id');

        try {
            $em = $this->getDoctrine()->getManager();

            //On récupére l'utilisateur persisté
            $user = $em
                ->getRepository('CZSUserBundle:User')
                ->find(array("id" => $idUser));

            //On applique les nouvelles valeurs
            if(!is_null($email)) {
                $user->setEmail($email);
            }
            if(!is_null($username)){
                $user->setUsername($username);
            }

            // On persiste
            $this->getDoctrine()->getManager()->flush();

            //On renvoie la réponse si ok
            $response->setContent($user->getId());
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/html');
        }
        catch (\Exception $e){
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);
        }

        return $response;
    }


    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "User delete",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "User is delete"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *      {"name"="username", "dataType"="string", "required"=false,"description"="username"},
     *  }
     * )
     *
     */
    public function deleteDeleteAction($username)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        if(is_null($username))
        {
            $response->setContent("Nom d'utilisateur obligatoire");
            $response->setStatusCode(401);
            return $response;
        }

        try {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($username);
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            $response->setStatusCode(200);
        }
        catch (\Exception $e){
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);
        }


        return $response;

    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "C",
     *   statusCodes = {
     *     401 = "Database exception",
     *     402 = "Request parameter exception",
     *     200 = "Loan is done"
     *   },
     *   tags={
     *         "stable"
     *   },
     * requirements={
     *      {"name"="idUser", "dataType"="integer", "required"=true,"description"="idUser"},
     *      {"name"="idEquipment", "dataType"="integer", "required"=true,"description"="idEquipment"},
     *      {"name"="dateBegin", "dataType"="date","description"="dateBegin"},
     *  }
     *)
     *
     */
    public function postAffectEquipmentAction(Request $request)
    {
        //On récupére les infos du $request
        $idUser    = $request->get('idUser');
        $idEquipment  = $request->get('idEquipment');
        $dateBegin = new \Datetime();
        $em = $this->getDoctrine()->getManager();

        //Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        try
        {
            // On récupére l'utilisateur
            $user = $em
                ->getRepository('CZSUserBundle:User')
                ->find(array("id" => $idUser));

            // On récupére l'equipement
            $equipment = $em
                ->getRepository('CZSUserBundle:Equipment')
                ->find($idEquipment);

            // Affection de l'utilisateur à l'equipment
            $equipment->setUser($user);


            // Creation du pret dans la table d'historique
            $loan = new Loan();
            $loan->setDateBegin($dateBegin);
            $loan->addEquipment($equipment);
            $loan->addUser($user);
            $this->getDoctrine()->getManager()->persist($loan);


            // Cloture du pret si existant dans la table d'historique
            $loanRepository  = $em
                ->getRepository('CZSUserBundle:Loan');


            $loans = $loanRepository->myFindByEquipmentAndEndDate($equipment->getId());

            $loanEnd = new Loan();
            foreach($loans as $loanEnd)
            {
                $loanEnd->setDateEnd(new \Datetime());
            }

            //On flush
            $this->getDoctrine()->getManager()->flush();

            $response->setStatusCode(200);



        }catch (\Exception $e){
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);

        }

        return $response;

    }


    /**
     * @ApiDoc(
     *   resource = true,
     *   section = "User",
     *   description = "CZD access",
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
     *
     */

    public function postCzdAction(){
        $url = 'http://api0.cityzendata.net:8080/api/v0/exec/einstein';


        $body = "'UDL9ZxXvRAOuWvqB9xIIswIB6h8X6hoziSRgx3olBX4='\r"."'token'\r"."STORE\r".'$token'."\r"."'~com.smartsensing.data.Speed'\r"."'userid'\r"."'4'\r"."'sessionid'\r"."'3'\r"."4 ->MAP\r"."'2010-01-01T00:00:00.000Z'\r"."'2952-01-01T00:00:00.000Z'\r"."5 ->LIST FETCH";

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: text/xml\r\n",
                'content' => $body,
                'timeout' => 60
            )
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents($url, false, $context, -1, 40000);




        return $body;
    }

}
