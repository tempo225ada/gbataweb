<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DemandeImmo;
use AppBundle\Form\DemandeImmoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DemandeImmoController extends Controller
{

    /**
     * @Route("/add/demande/immo", name="add_demande_immo")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index (Request $request) {

        $demande = new DemandeImmo();
        $form = $this->createForm(DemandeImmoType::class, $demande);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
        }

        return $this->render('/admin/demande_immo.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
