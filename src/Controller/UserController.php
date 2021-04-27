<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\Recuperertype;
use App\Form\SendType;
use App\Form\UserType;
use App\Repository\TherapeuteRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Swift_Message;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('type' => 'client'));





        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/backtherapeute", name="user_back", methods={"GET"})
     */
    public function indexback(): Response
    {


        return $this->render('baseBackthe.html.twig');}




    /**
     * @Route("/backadmin", name="user_backa", methods={"GET"})
     */
    public function indexbacka(UserRepository $repo): Response
    {

        $typeEtat= [];
        $countEtat = [];

        $StatEtat= $repo->statEtatUser();

        foreach ($StatEtat as $StatEtat) {
            $typeEtat[] = $StatEtat['etat'];
            $countEtat[] = $StatEtat['countEtat'];
        }

        $typeEtat2= [];
        $countEtat2 = [];

        $StatEtat2= $repo->statEtatUser2();

        foreach ($StatEtat2 as $StatEtat2) {
            $typeEtat2[] = $StatEtat2['etat'];
            $countEtat2[] = $StatEtat2['countEtat'];
        }
        return $this->render('user/accueilBackAdmin.html.twig', [
            'typeEtat'=>  json_encode($typeEtat),
            'countEtat'=> json_encode($countEtat),
            'typeEtat2'=>  json_encode($typeEtat2),
            'countEtat2'=> json_encode($countEtat2),

        ]);

    }
    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,Recaptcha3Validator $recaptcha3Validator,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
$user->setPassword(md5($user->getPassword()));
            $user->setType("client");
            $user->setEtat("attente");
            $entityManager->persist($user);
            $entityManager->flush();


            $this->notifyUser("zenlifezenlife02@gmail.com",$user->getEmail(),$user->getNom(),$mailer);


            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/inscription1.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/ban", name="user_ban", methods={"GET","POST"})
     */
    public function ban(Request $request, User $user): Response
    {
        $user->setEtat("banned");

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_index');


    }

    /**
     * @Route("/{id}/confirm", name="user_confirm", methods={"GET","POST"})
     */
    public function confirm(Request $request, User $user): Response
    {
        $user->setEtat("inscrit");

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');


    }

    /**
     * @Route("confirm/{email}", name="Activation", methods={"GET","POST"})
     */
    public function Activation(Request $request, $email): Response
    {
    $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(array('email'=>$email));
        $user->setEtat("inscrit");

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_index');


    }



    public function notifyUser($emailSource,$emailDestination,$nomprenom,\Swift_Mailer $mailer)
    {
        // On construit le mail
        $message = (new \Swift_Message('Bienvenu '.$nomprenom))

        ->setFrom($emailSource)
        // Destinataire
        ->setTo($emailDestination);
        $image= $message->embed(\Swift_Image::fromPath('images/logo.JPG'));
        // Corps du message
        $message->setBody(
            $this->render(
                'user/UserVerification.html.twig',['nomprenom'=>$nomprenom,'email'=>$emailDestination,'imageurl'=>$image]
            ),
            'text/html'
        );

        // On envoie le mail
        $mailer->send($message);

    }


    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/login/login", name="user_login", methods={"GET","POST"})
     */
    public function login(Request $request,UserRepository $userrep,TherapeuteRepository $repository){
        $user=new User();
        $a=$userrep->moyenne();
        $som=0;
        foreach ($a as $av){
            $som=$som+$av->getRating();

        }

        $avg=$som/sizeof($a)-1;

        $session = $request->getSession();
        $session->set('email',"");
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $email=$user->getEmail();
            $mdp=md5($user->getPassword());
            $id=$user->getId();
            $etat="inscrit";
            $type="admin";

            $user1=$userrep->finduser($email,$mdp,$etat);
            $user2=$repository->findThere($email,$mdp);
            $user3=$userrep->findadmin($email,$mdp,$type);
            if($user3 !=  null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                $session->set('id',$id);
                return $this->redirectToRoute("user_backa");

            }
            if($user2 !=  null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                $session->set('id',$id);

                return $this->redirectToRoute("accueil_show");

            }
            if($user1 != null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                $session->set('id',$id);

                return $this->redirectToRoute("accueilfront_index");
            }
else {
    $this->addFlash('notice', 'Verifier cos parametres ou vous etes exclu ou en attente !');

}



        }

        return $this->render('user/Login.html.twig', [

            'form' => $form->createView(),'moy'=>$avg
        ]);

    }
    /**
     * @Route("/oublier/oublier", name="user_oublier", methods={"GET","POST"})
     */
    public function oublier(Request $request,\Swift_Mailer $mailer){
        $session = $request->getSession();


        $user=new User();
        $form = $this->createForm(SendType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() ) {

            $random = random_int(100000, 1000000);
$a=strval($random);
            $session->set('email',$user->getEmail());

            $session->set('mdp',$random);
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('zenlifezenlife02@gmail.com')
                ->setTo($user->getEmail())
                ->setSubject('code de recuperation du mot de passe')
                ->setBody(strval($random));

            $mailer->send($message);
            return $this->redirectToRoute("user_modifierm",['user' => $user]);








        }

        return $this->render('user/oublier.html.twig', [

            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/oublier/modifier", name="user_modifierm", methods={"GET","POST"})
     */
    public function modifier(Request $request){
        $session = $request->getSession();
        $user=new User();
        $form = $this->createForm(Recuperertype::class, $user);
        $form->handleRequest($request);
        $a=$session->get("email");
        $b=$session->get("mdp");

        if ($form->isSubmitted() ) {
            if ($b==$user->getCode()&&($user->getPassword()==$user->getPassword1()))
            {

               $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
                   ['email' => $a],
               );

              $user2->setPassword(md5($user->getPassword()));
                $this->getDoctrine()->getManager()->flush();
                $session->invalidate();
                return $this->redirectToRoute("user_login");





            }

else {

    $this->addFlash('notice', 'Verifiez vos parametres');



}








        }

        return $this->render('user/recuperer.html.twig', [

            'form' => $form->createView(),
        ]);

    }


}
