<?php

namespace AppBundle\Controller;

use AppBundle\Entity\bientype;
use AppBundle\Form\bientypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BienTypeController extends Controller
{

    /**
     * @Route("/add/typebien", name="type_bien")
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
     * @Route("/add/list/typebien", name="list_typebien")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list() {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:bientype');
        $type_bien = $repository->findAll();
        return $this->render('admin/list_typebien.html.twig', [
           'type_biens' => $type_bien
        ]);

    }
}
