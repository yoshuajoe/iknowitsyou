<?php 
namespace Ikiy\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 *
 * @package Ikiy\AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
    	//echo "halo"; die();
        return $this->render('home/home.html.twig');
    }
}
