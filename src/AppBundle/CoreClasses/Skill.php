<?php

namespace AppBundle\CoreClasses;

class Skill
{
    Public $Name;
    Public $AbilityName;
    Public $Ranks;
    Public $ArmorCheckPenaltyApplies;
    Public $MiscBonus = 0;

    //Boolean
    //This is whether the skill is a calculated based on another skill
    //and a class level.  The $OtherSkillName is the skill to use in the calculation
    //and $ClassName is the class to use.
    Public $SkillClassLevelCaluclation = False;

    //String
    //The name of the other skill to use in the calculation of this skill.
    Public $OtherSkillName;

    //String
    //The name of the class for the class level to use in the calculation of this skill.
    Public $ClassName;

    function __construct($Name, $AbilityName, $ArmorCheckApplies) {
      $this->Name=$Name;
      $this->AbilityName=$AbilityName;
      $this->Ranks = 0;
      $this->ArmorCheckPenaltyApplies = $ArmorCheckApplies;
   }
}
