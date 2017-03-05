<?php

namespace AppBundle\AttackCalculator;

class AttackModifier
{
    public $UniqueName;
    public $DisplayName;
    public $IsToggleable;
    public $Modifier;

    function __construct($uniq, $name, $toggle, $mod) {
      $this->UniqueName=$uniq;
      $this->DisplayName=$name;
      $this->IsToggleable=$toggle;
      $this->Modifier=$mod;
   }
}
