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

    private function generateModifiers()
    {
      $modifiers = [];
      $mod = new AttackModifier;
      $mod->DisplayName="Dex";
      $mod->UniqueName="dex";
      $mod->IsToggleable = False;
      $mod->Modifier = 5;
      $modifiers[$mod->UniqueName]=$mod;

      $mod1 = new AttackModifier;
      $mod1->DisplayName="BAB";
      $mod1->UniqueName="bab";
      $mod1->IsToggleable = False;
      $mod1->Modifier = 3;
      $modifiers[$mod1->UniqueName]=$mod1;

      $mod2 = new AttackModifier;
      $mod2->DisplayName="Weapon Attack Modifier";
      $mod2->UniqueName="weaponAttackModifier";
      $mod2->IsToggleable = False;
      $mod2->Modifier = 1;
      $modifiers[$mod2->UniqueName]=$mod2;

      $mod3 = new AttackModifier;
      $mod3->DisplayName="Weapon Focus";
      $mod3->UniqueName="weaponFocus";
      $mod3->IsToggleable = False;
      $mod3->Modifier = 1;
      $modifiers[$mod3->UniqueName]=$mod3;

      $mod4 = new AttackModifier;
      $mod4->DisplayName="Flanked?";
      $mod4->UniqueName="flanked";
      $mod4->IsToggleable = True;
      $mod4->Modifier = 2;
      $modifiers[$mod4->UniqueName]=$mod4;

      $mod5 = new AttackModifier;
      $mod5->DisplayName="Invisible?";
      $mod5->UniqueName="invisible";
      $mod5->IsToggleable = True;
      $mod5->Modifier = 2;
      $modifiers[$mod5->UniqueName]=$mod5;

      $mod6 = new AttackModifier;
      $mod6->DisplayName="Using Offhand?";
      $mod6->UniqueName="offhand";
      $mod6->IsToggleable = True;
      $mod6->Modifier = -2;
      $modifiers[$mod6->UniqueName]=$mod6;

      return $modifiers;
    }

    private function getCharacterModifiers($characterName, $allModifiers)
    {
      $characterModifiers = [];
      switch ($characterName) {
        case 'Thrynn':
          $characterModifiers[count($characterModifiers)] = $allModifiers["dex"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["bab"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["weaponAttackModifier"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["weaponFocus"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["flanked"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["invisible"];
          $characterModifiers[count($characterModifiers)] = $allModifiers["offhand"];
          break;

        default:
          break;
      }
      return $characterModifiers;
    }
}
