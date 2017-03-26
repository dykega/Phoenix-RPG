<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\CoreClasses\PlayerCharacter;
use AppBundle\CoreClasses\Ability;
use AppBundle\CoreClasses\RPGClass;
use AppBundle\CoreClasses\Skill;

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
                    "dex"=>new Ability("Dex",20,0),
                    "con"=>new Ability("Con",12,0),
                    "int"=>new Ability("Int",12,0),
                    "wis"=>new Ability("Wis",8,0),
                    "cha"=>new Ability("Cha",12,0)
                ];
                $character->Abilities = $abilities;
                $character->Alignment="Neutral Good";

                //populate ranks
                $character->Skills["acrobatics"]->Ranks=3;
                $character->Skills["appraise"]->Ranks=1;
                $character->Skills["bluff"]->Ranks=3;
                $character->Skills["climb"]->Ranks=1;
                $character->Skills["diplomacy"]->Ranks=4;
                $character->Skills["disable device"]->Ranks=4;
                $character->Skills["disguise"]->Ranks=1;
                $character->Skills["escape artist"]->Ranks=1;
                $character->Skills["fly"]->Ranks=0;
                $character->Skills["handle animal"]->Ranks=1;
                $character->Skills["heal"]->Ranks=0;
                $character->Skills["intimidate"]->Ranks=1;
                $character->Skills["linguistics"]->Ranks=1;
                $character->Skills["perception"]->Ranks=4;
                $character->Skills["ride"]->Ranks=0;
                $character->Skills["sense motive"]->Ranks=1;
                $character->Skills["sleight of hand"]->Ranks=4;
                $character->Skills["spellcraft"]->Ranks=1;
                $character->Skills["stealth"]->Ranks=4;
                $character->Skills["survival"]->Ranks=0;
                $character->Skills["swim"]->Ranks=1;
                $character->Skills["use magic device"]->Ranks=1;
                $character->Skills["knowledge (dungeoneering)"]->Ranks=1;
                $character->Skills["knowledge (local)"]->Ranks=3;
                $character->Skills["knowledge (arcana)"]->Ranks=1;
                $character->Skills["knowledge (nature)"]->Ranks=1;
                $character->Skills["knowledge (religion)"]->Ranks=1;

                //Add skills from trap sense (which I don't really have but help test)
                $skill = new Skill("disarm traps","","");
                $skill->SkillClassLevelCaluclation = True;
                $skill->OtherSkillName = "disable device";
                $skill->ClassName = "rogue";
                $character->Skills[$skill->Name]=$skill;
                $skill = new Skill("locate traps","","");
                $skill->SkillClassLevelCaluclation = True;
                $skill->OtherSkillName = "perception";
                $skill->ClassName = "rogue";
                $character->Skills[$skill->Name]=$skill;


                //create the class
                $rogueClass = new RPGClass("rogue",["acrobatics","appraise","bluff",
                "climb","craft","diplomacy","disable device","disguise","escape artist",
                "intimidate","knowledge (dungeoneering)","knowledge (local)",
                "linguistics","perception","perform","profession","sense motive",
                "sleight of hand","stealth","swim","use magic device"]);
                $rogueClass->Level = 4;
                $character->Classes["rogue"]=$rogueClass;

                $character->ArmorCheckPenalty = -1;
                break;

                case 'Ea':
                    $abilities =
                    [
                        "str"=>new Ability("Str",18,0),
                        "dex"=>new Ability("Dex",14,0),
                        "con"=>new Ability("Con",16,0),
                        "int"=>new Ability("Int",8,0),
                        "wis"=>new Ability("Wis",10,0),
                        "cha"=>new Ability("Cha",10,0)
                    ];
                    $character->Abilities = $abilities;
                    $character->Alignment="Neutral Good";

                    //populate ranks
                    $character->Skills["acrobatics"]->Ranks=1;
                    $character->Skills["appraise"]->Ranks=1;
                    $character->Skills["bluff"]->Ranks=2;
                    $character->Skills["climb"]->Ranks=1;
                    $character->Skills["diplomacy"]->Ranks=2;
                    $character->Skills["disable device"]->Ranks=1;
                    $character->Skills["disguise"]->Ranks=0;
                    $character->Skills["escape artist"]->Ranks=0;
                    $character->Skills["fly"]->Ranks=0;
                    $character->Skills["handle animal"]->Ranks=0;
                    $character->Skills["heal"]->Ranks=0;
                    $character->Skills["intimidate"]->Ranks=3;
                    $character->Skills["linguistics"]->Ranks=0;
                    $character->Skills["perception"]->Ranks=1;
                    $character->Skills["ride"]->Ranks=0;
                    $character->Skills["sense motive"]->Ranks=0;
                    $character->Skills["sleight of hand"]->Ranks=0;
                    $character->Skills["spellcraft"]->Ranks=0;
                    $character->Skills["stealth"]->Ranks=3;
                    $character->Skills["survival"]->Ranks=1;
                    $character->Skills["swim"]->Ranks=0;
                    $character->Skills["use magic device"]->Ranks=0;
                    $character->Skills["knowledge (nature)"]->Ranks=1;

                    //Add misc bonus to survival
                    $character->Skills["survival"]->MiscBonus=1;


                    //create the class
                    $spiritWarriorClass = new RPGClass("spirit warrior",["acrobatics",
                    "climb","craft","handle animal","intimidate","knowledge (nature)",
                    "perception","ride","survival","swim","knowledge (geography)"]);
                    $spiritWarriorClass->Level = 4;
                    $character->Classes["spirit warrior"]=$spiritWarriorClass;

                    $character->ArmorCheckPenalty = 0;
                    break;
        }
        return $character;
    }
}
