<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Immobilier;
use AppBundle\Form\ImmobilierType;
use AppBundle\Entity\ImmobilierSearch;
use AppBundle\Entity\User;
use AppBundle\Form\ImmobilierEditType;
use AppBundle\Form\ImmobilierSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Service\FileUploader;


class ImmobilierController extends Controller
{

    //Ajout d'une offre immobiliere
    /**
     * @Route("/annonceur/add/immobilier", name="add_immobilier")
     */
    public function index ( Request $request, FileUploader $fileUploader) {

        //Création du formulaire
        $immobilier = new Immobilier();
        $form = $this->createForm(ImmobilierType::class, $immobilier);

        //vérification du formulaire

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {
            // Gestion de la validation des images
            $image_immo = $form['image']->getData();
            $image_immo2 = $form['image2']->getData();
            $image_immo3 = $form['image3']->getData();
            if($image_immo || $image_immo2 || $image_immo3) {

                $originalFilename = $fileUploader->upload($image_immo);
                $originalFilename2 = $fileUploader->upload($image_immo2);
                $originalFilename3 = $fileUploader->upload($image_immo3);

                $immobilier->setImageImmo($originalFilename);
                $immobilier->setImageImmo2($originalFilename2);
                $immobilier->setImageImmo3($originalFilename3);
            }
                
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            //$user = $this->getUser()->getId();
            $user = $this->getUser();
            $immobilier->setUtilisateur($user);

            $immobilier->setDatecreation(new \DateTime());
            $immobilier->setDatemodifcation(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($immobilier);
            $em->flush();
            $this->addFlash('success', 'Votre offre a été enregistrée avec succès');

            return $this->redirectToRoute('user_list_immo');


        }

        return $this->render('admin/immobilier.html.twig', [

            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/offre/immobilier", name="list_immobilier")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function liste( Request $request, PaginatorInterface $paginator) {

        $search = new ImmobilierSearch();
        $form = $this->createForm(ImmobilierSearchType::class, $search);
        $form->handleRequest($request);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobiliers = $repository->findAllImmobilier($search);
        
        // Pagination des offre avec KNP pagination
        $pagination = $paginator->paginate($immobiliers,
                             $request->query->getInt('page', 1), 
                             9 
                        );

        return $this->render('pages/immobilier_list.html.twig', [
            'immobiliers' => $pagination,
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/admin/list/immobilier", name="admin_list_immo")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function liste_immobilier_admin(Request $request, PaginatorInterface $paginator) {
        //$search = new ImmobilierSearch();
        $search = new ImmobilierSearch();
        $form = $this->createForm(ImmobilierSearchType::class, $search);
        $form->handleRequest($request);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        //$immobiliers = $repository->findAll();
        $immobiliers = $repository->findAllImmobilier($search);

        $pagination = $paginator->paginate($immobiliers,
        $request->query->getInt('page', 1), 
        20 
   );

        return $this->render('admin/list/list_immobilier.html.twig', [
            'immobiliers' => $pagination,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/annonceur/list/immobilier", name="user_list_immo")
     */

    public function user_list_immo(Request $request, PaginatorInterface $paginator) {
        $user = $this->getUser();
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobilier = $repository->findByUtilisateur($user);

        $pagination = $paginator->paginate($immobilier,
        $request->query->getInt('page', 1), 
        20 
    );
        return $this->render('user/list_immobilier.html.twig', [
            'immobiliers' =>  $pagination
        ]);

    }
    

    /**
     * @Route("/annonceur/immobilier/{id}/edit", name="admin_immobilier_edit")
     * @param Immobilier $immobilier
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit( Immobilier $immobilier, Request $request, EntityManagerInterface $em) {
       
        if($immobilier->getUtilisateur() !== $this->getUser()){
            $this->addFlash('danger', 'Vous n\'avez pas les accès pour modifier cette annonce, cette offre ne vous appartient peut être pas');
            return $this->redirectToRoute('user_list_immo');
        }

        $form = $this->createForm(ImmobilierEditType::class, $immobilier);
        $user = $this->getUser();
        $immobilier->setUtilisateur($user);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            $immobilier = $form->getData();
            $immobilier->setDatemodifcation(new \DateTime());
            $em->persist($immobilier);
            $em->flush();
            return $this->redirectToRoute('user_list_immo');
        }

        return $this->render('/admin/edit/edit_immobilier.html.twig', [
            'form' => $form->createView()
        ]);
    } 


    /**
     * @Route("/annonceur/immobilier/{id}/delete", name="admin_immobilier_delete")
     * @param Immobilier $immobilier
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function delete(Immobilier $immobilier, Request $request, EntityManagerInterface $em) {
         $file1 = $immobilier->getImageImmo();
         $file2 = $immobilier->getImageImmo2();
         $file3 = $immobilier->getImageImmo3();

         $projectDir = $this->get('kernel')->getProjectDir();
         $filesystem = new Filesystem();
 
         $path=$projectDir.'/web/upload/image_immo/'.$file1;
         $filesystem->remove($path);
     
         $path2=$projectDir.'/web/upload/image_immo/'.$file2;
         $filesystem->remove($path2);

         $path3=$projectDir.'/web/upload/image_immo/'.$file3;
         $filesystem->remove($path3);

         $em->remove($immobilier);
         $em->flush();
         return $this->redirectToRoute('user_list_immo');
     }


    /**
     * @Route("/offres/immobilier/{id}", name="contenu_immobilier")
     */

    public function contenu_immobilier($id,Immobilier $immobilier ) {
    
    
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user_id = $immobilier->getUtilisateur(); 
        // Recherche d'un seul article par son titre

        $username = $repositoryUser->findOneBy(['username' => $user_id->__toString()]);
       // $usermail = $repositoryUser->findOneBy(['email' => $user_id->__toString()]);
      
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobilier_contenu = $repository->find($id);

        if(!$immobilier_contenu) {
            // S'il y a aucun article, nous affichons une exception
            throw $this->createNotFoundException('l\'offre n\'existe sans doute pas');
        }

        // Sinon si l'article existe

        return $this->render('pages/immobilier_contenu.html.twig', [
            'immobilier' =>  $immobilier_contenu,
            'user_name'=> $username
        ]);

    }

     /**
     * @Route("/user/immobilier/{username}", name="user_immobilier")
     */

    public function user_immobilier($username,Immobilier $immobilier,User $user) {
    
    
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user_id = $immobilier->getUtilisateur();
        $id_user = $user->getId(); 
        // Recherche d'un seul article par son titre

        $username = $repositoryUser->findOneBy(['username' => $user_id->__toString()]);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobilier_contenu = $repository->findAll($id_user);

        if(!$immobilier_contenu) {
            // S'il y a aucun article, nous affichons une exception
            throw $this->createNotFoundException('l\'offre n\'existe sans doute pas');
        }

        // Sinon si l'article existe

        return $this->render('pages/immobilier_contenu.html.twig', [
            'immobilier' =>  $immobilier_contenu,
            'user_name' => $username
        ]);

    }

    
}
