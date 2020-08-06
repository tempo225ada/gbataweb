<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\UserEditType;
use AppBundle\Form\UserProfileType;
use AppBundle\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UserController extends Controller {

    /**
     * @Route("/inscription", name="sign_up")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder) {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $pass = $form['password']->getData();
            $encoded = $encoder->encodePassword($user, $pass);
            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('pages/inscription.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/list/user", name="list_user")
     */
    public function list() {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:User');
        $user = $repository->findAll();
        return $this->render('admin/list/list_user.html.twig', array(
            'users'=> $user
        ));
    }

      /**
     * @route("/user/profile/edit", name="edit_profile_user")
     */

    public function editProfile(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) : Response{

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
 
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $pass = $form['password']->getData();
            $encoded = $encoder->encodePassword($user, $pass);
            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_list_immo');
        }

        return $this->render('/user/edit_profile_user.html.twig', [
            'form' => $form->createView()
        ]);
     }

    /**
     * @route("/user/{id}/edit", name="edit_user")
     */

    public function edit(User $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) {

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_list_immo');
        }

        return $this->render('/user/edit_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    

}
