<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BootstrapController extends Controller
{
    /**
     * @Route("/bootstrap/{pageName}")
     */
    public function showAction($pageName)
    {
      $templating = $this->container->get('templating');
      $html = $templating->render('bootstrap/' . $pageName . '/index.html.twig');
      return new Response($html);
    }
}
