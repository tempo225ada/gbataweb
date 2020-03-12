<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DemandeImmo;
use AppBundle\Form\DemandeImmoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DemandeImmoController extends Controller
{

    /**
     * @Route("/user/add/demande/immo", name="add_demande_immo")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index (Request $request) {

        $demande = new DemandeImmo();
        $user = $this->getUser();
        $demande->setUtilisateur($user);
        $form = $this->createForm(DemandeImmoType::class, $demande);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
        }

        return $this->render('/user/demande_immo.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/user/list/demande/immo", name="user_list_demande_immo")
     * @return string
     */

    public function list_demande_user() {
        $user = $this->getUser();
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(DemandeImmo::class);
        $demande = $repository->findByUtilisateur($user);

        return $this->render('user/list_demande_immo.html.twig', [
            'demandes' => $demande
        ]);
    }

    /**
     * @Route("/admin/list/demande/immo", name="admin_list_demande_immo")
     * @return string
     */

    public function list() {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(DemandeImmo::class);
        $demande = $repository->findAll();

        return $this->render('admin/list/list_demande_immo.html.twig', [
            'demandes' => $demande
        ]);
    }

    /**
     * @Route("/admin/demande/immo/{id}/edit", name="admin_demande_immo_edit")
     * @param DemandeImmo $demandeImmo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function edit(DemandeImmo $demandeImmo, Request $request, EntityManagerInterface $em) {

        $form = $this->createForm(DemandeImmoType::class, $demandeImmo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeImmo= $form->getData();
            $em->persist($demandeImmo);
            $em->flush();

            return $this->redirectToRoute('admin_list_demande_immo');
        }

        return $this->render('admin/edit/edit_demande_immo.html.twig', [
           'form'=>$form->createView()
        ]);

    }
}
