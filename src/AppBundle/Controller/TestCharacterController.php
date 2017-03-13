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
        switch ($character->Name) {
            case 'Thrynn':
                $abilities =
                [
                    "str"=>new Ability("Str",10,0),
                    "dex"=>new Ability("Dex",21,0),
                    "con"=>new Ability("Con",12,0),
                    "int"=>new Ability("Int",12,0),
                    "wis"=>new Ability("Wis",8,0),
                    "cha"=>new Ability("Cha",11,0)
                ];
                $character->Abilities = $abilities;
                $character->Alignment="Neutral Good";
                break;
        }
        //$ab = "Abilities";
        //$t = "dex";
        //$x = "BaseScore";
        //$character->Name = call_user_func_array([$character->$ab[$t],"Modifier"],[]);
        return $character;
    }
}
