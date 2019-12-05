<?php 

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ContactController	extends Controller {

/**
 * @Route("/contacts", name="contact")
 */
	public function index () {

		return $this->render('pages/contacts.html.twig');

	}
}
