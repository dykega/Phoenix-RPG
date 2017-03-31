<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpellsController extends Controller
{
    /**
     * @Route("/Test/Spells")
     */
    public function showAction()
    {
      $templating = $this->container->get('templating');
      $html = $templating->render('test/Spells/Spells.html.twig');
      return new Response($html);
    }
}
