<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Immobilier;
use AppBundle\Form\ImmobilierType;
use AppBundle\Form\ImmobilierEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;


class ImmobilierController extends Controller
{
    //Ajout d'une offre immobiliere
    /**
     * @Route("/annonceur/add/immobilier", name="add_immobilier")
     */

    public function index ( Request $request) {

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
            if($image_immo || $image_immo2 || $image_immo3 ) {

                $originalFilename = pathinfo($image_immo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image_immo->guessExtension();
                
                $originalFilename2 = pathinfo($image_immo2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename2 = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename2);
                $newFilename2 = $safeFilename2.'-'.uniqid().'.'.$image_immo2->guessExtension();

                $originalFilename3 = pathinfo($image_immo3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename3 = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename3);
                $newFilename3 = $safeFilename3.'-'.uniqid().'.'.$image_immo3->guessExtension();
                
                //deplacer les images dans le dossier approprié upload/imageimmo

                try {
                    $image_immo->move(
                        $this->getParameter('image_immo'),
                        $newFilename
                    );
                    $image_immo2->move(
                        $this->getParameter('image_immo2'),
                        $newFilename2
                    );
                    $image_immo3->move(
                        $this->getParameter('image_immo3'),
                        $newFilename3
                    );
                }
                catch (FileException $e) {

                }
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
                //$user = $this->getUser()->getId();
                $user = $this->getUser();
                $immobilier->setUtilisateur($user);
                $immobilier->setImageImmo($newFilename);
                $immobilier->setImageImmo2($newFilename2);
                $immobilier->setImageImmo3($newFilename3);
                $em = $this->getDoctrine()->getManager();
                $em->persist($immobilier);
                $em->flush();
                $this->addFlash('success', 'Votre offre a été enregistrée avec succès');

                return $this->redirectToRoute('user_list_immo');
             
            }

        }

        return $this->render('admin/immobilier.html.twig', [

            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/offre/immobilier", name="list_immobilier")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function liste() {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobiliers = $repository->findAll();

        return $this->render('pages/immobilier_list.html.twig', [
            'immobiliers' => $immobiliers
        ]);

    }


    /**
     * @Route("/admin/list/immobilier", name="admin_list_immo")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function liste_immobilier_admin() {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobiliers = $repository->findAll();
        return $this->render('admin/list/list_immobilier.html.twig', [
            'immobiliers' => $immobiliers
        ]);
    }

    /**
     * @Route("/user/list/immobilier", name="user_list_immo")
     */

    public function user_list_immo() {
        $user = $this->getUser();
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobilier = $repository->findByUtilisateur($user);

        return $this->render('user/list_immobilier.html.twig', [
            'immobiliers' => $immobilier
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
            $em->persist($immobilier);
            $em->flush();

            return $this->redirectToRoute('admin_list_immo');
        }

        return $this->render('/admin/edit/edit_immobilier.html.twig', [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/offres/immobilier/{id}", name="contenu_immobilier")
     */

    public function contenu_immobilier($id) {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        $immobilier_contenu = $repository->find($id);

        if(!$immobilier_contenu) {
            // S'il y a aucun article, nous affichons une exception
            throw $this->createNotFoundException('l\'offre n\'existe sans doute pas');
        }

        // Sinon si l'article existe

        return $this->render('pages/immobilier_contenu.html.twig', [
            'immobilier' =>  $immobilier_contenu
        ]);

    }

}
