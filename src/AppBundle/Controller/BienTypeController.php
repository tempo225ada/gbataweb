<?php

namespace AppBundle\Controller;

use AppBundle\Entity\bientype;
use AppBundle\Form\bientypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BienTypeController extends Controller
{

    /**
     * @Route("/admin/add/typebien", name="type_bien")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index (Request $request) {

        $type_bien = new bientype();
        $form = $this->createForm(bientypeType::class, $type_bien);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type_bien);
            $em->flush();
        }

        return $this->render('admin/typebien.html.twig', [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/admin/list/typebien", name="list_typebien")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list() {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:bientype');
        $type_bien = $repository->findAll();
        return $this->render('admin/list/list_typebien.html.twig', [
           'type_biens' => $type_bien
        ]);

    }

    /**
     * @Route("/admin/typebien/{id}/edit", name="admin_type_edit")
     * @param bientype $bientype
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response|void
     */

    public function edit( bientype $bientype, Request $request, EntityManagerInterface $em) {

        $form= $this->createForm(bientypeType::class, $bientype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           $bientype = $form->getData();
           $em->persist($bientype);
           $em->flush();

           return $this->redirectToRoute('list_typebien');
        }

        return $this->render('admin/edit/edit_typebien.html.twig', [
            'form'=> $form->createView()
        ]);

    }
}
