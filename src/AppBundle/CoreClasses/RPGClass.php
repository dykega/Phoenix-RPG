<?php

namespace AppBundle\CoreClasses;

class RPGClass
{
    Public $Name;
    Public $Level;
    Public $SkillsPerLevel;
    Public $ClassTable;

    //Array
    //Contains strings whic are names of skils which are class skills
    PUblic $ClassSkills;

    function __construct($name, $classSkills) {
      $this->Name=$name;
      $this->ClassSkills = $classSkills;
   }
}
