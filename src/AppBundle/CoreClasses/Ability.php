<?php

namespace AppBundle\CoreClasses;

class Ability
{
    Public $Name;
    Public $BaseScore;
    Public $Temp;

    function __construct($Name, $BaseScore, $Temp) {
      $this->Name=$Name;
      $this->BaseScore=$BaseScore;
      $this->Temp=$Temp;
   }

    function Modifier()
    {
        return floor(($this->BaseScore - 10 + $this->Temp) / 2);
    }

    function TotalScore()
    {
        return $this->BaseScore + $this->Temp;
    }
}
