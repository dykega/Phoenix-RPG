<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\CoreClasses\PlayerCharacter;
use AppBundle\CoreClasses\Ability;

class TestCharacterController extends Controller
{
    /**
     * @Route("/Test/Character/{characterName}")
     */
    public function showAction($characterName)
    {
        $testCharacter = $this->createPlayerCharacter($characterName);
        $templating = $this->container->get('templating');
        $html = $templating->render('test/Character/Character.html.twig', array(
            'character' => $testCharacter
        ));
        return new Response($html);
    }

    private function createPlayerCharacter($characterName)
    {
        $character = new PlayerCharacter();
        $character->Name = $characterName;
        $ab = "Abilities";
        $t = "dex";
        $x = "BaseScore";
        switch ($character->Name) {
            case 'Thrynn':
                $abilities =
                [
                    "str"=>new Ability("str",10,0),
                    "dex"=>new Ability("dex",21,0),
                    "con"=>new Ability("con",12,0),
                    "int"=>new Ability("int",12,0),
                    "wis"=>new Ability("wis",8,0),
                    "cha"=>new Ability("cha",11,0)
                ];
                $character->Abilities = $abilities;
                break;
        }
        $character->Name = $character->$ab[$t]->$x;
        return $character;
    }
}
