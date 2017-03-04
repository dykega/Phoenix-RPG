<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AttackCalculatorController extends Controller
{
    /**
     * @Route("/Test/AttackCalculator/{characterName}")
     */
    public function showAction($characterName)
    {
      $templating = $this->container->get('templating');
      $html = $templating->render('test/AttackCalculator/AttackCalculator.html.twig', array(
            'characterName' => $characterName
        ));
      return new Response($html);
    }
}
