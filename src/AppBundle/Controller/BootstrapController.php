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
      // $html = $templating->render('bootstrap/show.html.twig', array(
      //       'name' => $pageName
      //   ));
      $html = $templating->render('bootstrap/blog/index.html');
      return new Response($html);
    }
}
