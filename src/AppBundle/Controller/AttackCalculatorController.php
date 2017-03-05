<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\AttackCalculator\AttackModifier;

class AttackCalculatorController extends Controller
{
    /**
     * @Route("/Test/AttackCalculator/{characterName}")
     */
    public function showAction($characterName)
    {
      $templating = $this->container->get('templating');
      $allModifiers = $this->generateModifiers();
      $characterModifiers = $this->getCharacterModifiers($characterName, $allModifiers);
      $toggleableModifiers = [];
      $baseModifier = 0;
      foreach ($characterModifiers as $mod) {
        if(!$mod->IsToggleable){
          $baseModifier += $mod->Modifier;
        }
        else{
          $toggleableModifiers[count($toggleableModifiers)] = $mod;
        }
      }
      $html = $templating->render('test/AttackCalculator/AttackCalculator.html.twig', array(
            'characterName' => $characterName,
            'toggleableModifiers' => $toggleableModifiers,
            'baseModifier' =>$baseModifier
        ));
      return new Response($html);
    }

    private function getCharacterModifiers($characterName, $allModifiers)
    {
      $characterModifiers = [];
      switch ($characterName) {
        case 'Thrynn':
          $characterModifiers[count($characterModifiers)] = $allModifiers["dexThrynn"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["babThrynn"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["masterWorkDaggerThrynn"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["weaponFocus"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["flanked"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["invisible"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["offhandLightTwoWeaponFighting"];
          break;

        case 'Ea':
          $characterModifiers[count($characterModifiers)] = $allModifiers["strEa"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["babEa"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["masterworkClubEa"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["rage"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["fatigued"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["offhandTwoWeaponFighting"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["flanked"];
          break;
      }
      return $characterModifiers;
    }

    private function generateModifiers()
    {
      $modifiers = [];

      //Thrynns Stats
      $mod = new AttackModifier("dexThrynn","Dex",False,5);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("babThrynn","BAB",False,3);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("masterWorkDaggerThrynn","Mastwork dagger?",False,1);
      $modifiers[$mod->UniqueName]=$mod;

      //Eas Stats
      $mod = new AttackModifier("strEa","Strength",False,3);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("babEa","BAB",False,4);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("masterworkClubEa","Club?",False,1);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("rage","Rage?",True,2);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("fatigued","Fatigued?",True,-1);
      $modifiers[$mod->UniqueName]=$mod;


      //Feats
      $mod = new AttackModifier("weaponFocus","Weapon Focus?",True,1);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("offhandLightTwoWeaponFighting","Using Offhand?",True,-2);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("offhandTwoWeaponFighting","Using Offhand?",True,-4);
      $modifiers[$mod->UniqueName]=$mod;

      //Conditions
      $mod = new AttackModifier("flanked","Flanked?",True,2);
      $modifiers[$mod->UniqueName]=$mod;
      $mod = new AttackModifier("invisible","Invisible?",True,2);
      $modifiers[$mod->UniqueName]=$mod;

      return $modifiers;
    }
}
