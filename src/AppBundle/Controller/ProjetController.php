<?php 
namespace AppBundle\Controller;

#use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * 
 */
class ProjetController extends Controller
{
	
	/**
	 * @Route("/le-projet", name="leprojet")
	 */

	public function leProjet(){

		return $this->render('pages/le_projet.html.twig', [

		]);


	}
}