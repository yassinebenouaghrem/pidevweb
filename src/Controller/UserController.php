<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\Recuperertype;
use App\Form\SendType;
use App\Form\UserType;
use App\Repository\TherapeuteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('type' => 'client'));

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setType("client");
            $user->setEtat("attente");
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/inscription.html.twig', [
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
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $email=$user->getEmail();
            $mdp=$user->getPassword();
            $etat="inscrit";
            $type="admin";

            $user1=$userrep->finduser($email,$mdp,$etat);
            $user2=$repository->findThere($email,$mdp);
            $user3=$userrep->findadmin($email,$mdp,$type);
            if($user3 !=  null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                return $this->redirectToRoute("therapeute_index");

            }
            if($user2 !=  null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                return $this->redirectToRoute("reco_index");

            }
            if($user1 != null){
                $session->start();

                $session->set('email',$email);
                $session->set('mdp',$mdp);
                return $this->redirectToRoute("front");
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
