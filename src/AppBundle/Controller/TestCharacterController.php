<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\CoreClasses\PlayerCharacter;

class TestCharacterController extends Controller
{
    /**
     * @Route("/Test/Character/{characterName}")
     */
    public function showAction($characterName)
    {
        $testCharacter = new
        $templating = $this->container->get('templating');
        $html = $templating->render('test/Character/Character.html.twig', array(
            'characterName' => $characterName
        ));
        return new Response($html);
    }
}
