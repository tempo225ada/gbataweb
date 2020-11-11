<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\DemandeImmo;
use AppBundle\Form\DemandeImmoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

    public function list(Request $request,PaginatorInterface $paginator) {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(DemandeImmo::class);

        if($request->query->getAlnum('piece')) {
            $repository= $repository->createQueryBuilder('di');
            $repository
                       ->andWhere('di.piece = :piece')
                       ->setParameter('piece',$request->query->getAlnum('piece'));
            $demandes = $repository->getQuery();
            $demandes = $demandes->getResult();
        }

        elseif($request->query->getAlnum('commune')) {
            $repository= $repository->createQueryBuilder('di');
            $repository
                       ->andWhere('di.commune = :commune')
                       ->setParameter('commune',$request->query->getAlnum('commune'));
            $demandes = $repository->getQuery();
            $demandes = $demandes->getResult();
        }

        elseif($request->query->getAlnum('budgetmin')) {
            $repository= $repository->createQueryBuilder('di');
            $repository
                       ->andWhere('di.budget >= :budgetmin')
                       ->setParameter('budgetmin',$request->query->getAlnum('budgetmin'));
            $demandes = $repository->getQuery();
            $demandes = $demandes->getResult();
        }
        
        elseif($request->query->getAlnum('budgetmax')) {
            $repository= $repository->createQueryBuilder('di');
            $repository
                       ->andWhere('di.budget <= :budgetmax')
                       ->setParameter('budgetmax',$request->query->getAlnum('budgetmax'));
            $demandes = $repository->getQuery();
            $demandes = $demandes->getResult();
        }

        else{
            $demandes = $repository->findAll();
            $pagination = $paginator->paginate($demandes,
            $request->query->getInt('page', 1), 
            20 
             );
        }

        $pagination = $paginator->paginate($demandes,
            $request->query->getInt('page', 1), 
            15 
        );

        return $this->render('admin/list/list_demande_immo.html.twig', [
            'demandes' => $pagination
        ]);
    }

    /**
     * @Route("/user/demande/immo/{id}/edit", name="user_demande_immo_edit")
     * @param DemandeImmo $demandeImmo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function edit(DemandeImmo $demandeImmo, Request $request, EntityManagerInterface $em) {

        if($demandeImmo->getUtilisateur() !== $this->getUser()){
            $this->addFlash('danger', 'Vous n\'avez pas les accès pour modifier cette annonce, cette offre ne vous appartient peut être pas');
            return $this->redirectToRoute('user_list_immo');
        }

        $form = $this->createForm(DemandeImmoType::class, $demandeImmo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeImmo= $form->getData();
            $em->persist($demandeImmo);
            $em->flush();

            return $this->redirectToRoute('user_list_demande_immo');
        }

        return $this->render('admin/edit/edit_demande_immo.html.twig', [
           'form'=>$form->createView()
        ]);

    }


     /**
     * @Route("/admin/demande/immo/{id}/edit", name="admin_demande_immo_edit")
     * @param DemandeImmo $demandeImmo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function editAdmin(DemandeImmo $demandeImmo, Request $request, EntityManagerInterface $em) {

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
