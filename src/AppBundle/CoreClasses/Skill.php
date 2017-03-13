<?php

namespace AppBundle\CoreClasses;

class Skill
{
    Public $Name;
    Public $AbilityName;
    Public $Ranks;

    function __construct($Name, $AbilityName) {
      $this->Name=$Name;
      $this->AbilityName=$AbilityName;
      $this->Ranks = 0;
   }
}
