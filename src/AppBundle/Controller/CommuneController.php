<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commune;
use AppBundle\Form\CommuneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommuneController	extends Controller {

    /**
     * @Route("/add/commune", name="add_commune")
     */
    public function index (Request $request) {

        //Création du formulaire
        $commune = new Commune();
        $form = $this->createForm(CommuneType::class, $commune);

        //Vérification du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($commune);
            $em->flush();
        }

        return $this->render('admin/commune.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/list/commune" , name="list_commune")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list () {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Commune');
        $commune = $repository->findAll();
        return $this->render('admin/list/list_commune.html.twig', array(
            'communes'=> $commune
        ));
    }

    /**
     * @Route("/admin/commune/{id}/edit", name="admin_commune_edit")
     * @param Commune $commune
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function edit( Commune $commune, Request $request, EntityManagerInterface $em) {

        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commune = $form->getData();
            $em->persist($commune);
            $em->flush();

            return $this->redirectToRoute('list_commune');
        }

        return $this->render('admin/edit/edit_commune.html.twig', [
            'form'=>$form->createView()
        ]);

    }

}
