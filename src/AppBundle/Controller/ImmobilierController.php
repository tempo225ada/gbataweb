<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Immobilier;
use AppBundle\Form\ImmobilierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ImmobilierController extends Controller
{
    /**
     * @Route("/add/immobilier", name="add_immobilier")
     */

    public function index ( Request $request) {

        //Création du formulaire
        $immobilier = new Immobilier();
        $form = $this->createForm(ImmobilierType::class, $immobilier);

        //vérification du formulaire

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($immobilier);
            $em->flush();
        }

        return $this->render('admin/immobilier.html.twig', [

            'form'=> $form->createView()
        ]);

    }
}
