<?php

namespace AppBundle\CoreClasses;

class PlayerCharacter
{
    //String
    Public $Name;

    //Array
    //[
    //  "abilityName"=>AbilityClass
    //]
    Public $Abilities;
    Public $Classes;
    Public $Race;
    Public $Alignment;
    Public $LevelUpTable;

    //Array
    //[
    //  "skillName"=>SkillClass
    //]
    Public $Skills;

    //Array
    //Skills that can be done untrained
    Private $untrainedSkills = ["acrobatics","appraise","bluff","climb","craft","diplomacy","disguise","escape artist","fly","heal","intimidate","perception","perform",
    "ride","sense motive","stealth","survival","swim"];

    Public $Feats;
    Public $Languages;
    Public $HitPoints;
    Public $Initiative;
    Public $Speed;
    Public $BaB;
    Public $Inventory;
    Public $CMB;
    Public $Saves;
    Public $AC;
    Public $Spells;

    function __construct() {
      $this->populateSkills();
   }

    //Returns the bonus for a given skill.  If the given skill can't be performed
    //untrained, and the character doesn't have any ranks in the skill, then this
    //function will return null.
    //skillName: String - the name of the skill to check
    Public function getSkillBonus($skillName)
    {
        $skillName = strtolower($skillName);
        //if we cant perform the skill, then return null
        if (!$this->canPerformSkill($skillName)) {
            return null;
        }
        $skill = $this->Skills[$skillName];
        $ranks = $skill->Ranks;

        //get the ability modifier to add to the score
        $abilityAddition = $this->Abilities[$skill->AbilityName]->Modifier();

        //get the class skill bonus to add to the score
        $classSkillBonus = 0;
        return $ranks + $abilityAddition + $classSkillBonus;
    }

    //returns whether the skill can be performed.  This means that the skill can't
    //be done untrained and the character has no ranks in it.
    //skillName: String - the name of the skill to check
    Public function canPerformSkill($skillName)
    {
        $skillName = strtolower($skillName);
        //if the given skill isn't even in our skills, return False
        if (!array_key_exists($skillName, $this->Skills)) {
            return False;
        }
        else {
            $ranks = $this->Skills[$skillName]->Ranks;
        }

        //if there are no ranks in this skill, and you can't do it untrained,
        //then return False
        if ($ranks == 0)
        {
            if (!$this->canDoSkillUntrained($skillName)) {
                return False;
            }
        }

        return True;
    }

    //returns whether a given skill can be performed untrained
    //skillName: String - the name of the skill to check
    Public function canDoSkillUntrained($skillName)
    {
        $skillName = strtolower($skillName);
        return in_array($skillName,$this->untrainedSkills);
    }

    //populate default skills
    private function populateSkills()
    {
        $skills = ["acrobatics","appraise","bluff","climb","craft","diplomacy","disable device",
        "disguise","escape artist","fly","handle animal","heal","intimidate","knowledge (arcana)",
        "knowledge (dungeoneering)","knowledge (engineering)","knowledge (geography)","knowledge (history)",
        "knowledge (local)","knowledge (nature)","knowledge (nobility)","knowledge (planes)","knowledge (religion)",
        "linguistics","perception","perform","profession","ride","sense motive","sleight of hand","spellcraft","stealth",
        "survival","swim","use magic device"];
        $skillAbilities = ["dex","int","cha","str","int","cha","dex","cha","dex","dex","cha","wis","cha","int",
        "int","int","int","int","int","int","int","int","int","int","wis","cha","wis","dex","wis","dex","int",
        "dex","wis","str","cha"];

        for ($i = 0; $i < count($skills); $i++)
        {
            $skill = new Skill($skills[$i],$skillAbilities[$i]);
            $this->Skills[$skill->Name]=$skill;
        }

    }
}
