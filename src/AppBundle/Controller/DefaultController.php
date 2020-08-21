<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Immobilier;
use AppBundle\Form\ImmobilierType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
       // return $this->render('base.html.twig', [
       //     'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
       // ]);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Immobilier');
        //$immobiliers = $repository->findAll();
        $immobiliers = $repository->findBy(array(),array('datecreation' => 'DESC'),3);

        return $this->render('default/index.html.twig', [
            'immobiliers' => $immobiliers
        ]);
    }
}
