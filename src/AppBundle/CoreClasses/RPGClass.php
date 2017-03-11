<?php

namespace AppBundle\CoreClasses;

class RPGClass
{
    Public $Name;
    Public $Level;
    Public $SkillsPerLevel;
    Public $ClassTable;

    function __construct($Name, $BaseScore, $Temp) {
      $this->Name=$Name;
      $this->BaseScore=$BaseScore;
      $this->Temp=$Temp;
   }

    function Modifier()
    {
        return ($this->BaseScore - 10 + $this->Temp) / 2;
    }
}
