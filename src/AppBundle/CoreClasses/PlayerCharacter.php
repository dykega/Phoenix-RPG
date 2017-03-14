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

    //Int
    //The armor check penalty (negative number)
    Public $ArmorCheckPenalty=0;

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

        //if it's a calculated skill, then return that calculated value
        if ($skill->SkillClassLevelCaluclation) {
            return $this->calculateSkillClassLevelBonus($skill);
        }
        $ranks = $skill->Ranks;

        //get the ability modifier to add to the score
        $abilityAddition = $this->Abilities[$skill->AbilityName]->Modifier();

        //get the class skill bonus to add to the score
        $classSkillBonus = 0;
        if ($ranks > 0) {
            foreach ($this->Classes as $class) {
                if (in_array($skillName,$class->ClassSkills)) {
                    $classSkillBonus = 3;
                }
            }
        }

        //calculate armor check penalty
        $armorCheckPen = 0;
        if ($skill->ArmorCheckPenaltyApplies)
        {
            $armorCheckPen = $this->ArmorCheckPenalty;
        }

        //get any misc bonuses
        $miscBonus = $skill->MiscBonus;

        return ($ranks + $abilityAddition + $classSkillBonus + $armorCheckPen + $miscBonus);
    }

    //Returns the skill bonus for a calculated skill based on another skill
    //and a class level.
    //skill: String - the skill to check
    private function calculateSkillClassLevelBonus($skill)
    {
        $baseSkillBonus = 0;
        $classLevel = 0;
        if (array_key_exists($skill->OtherSkillName,$this->Skills)) {
            $baseSkillBonus = $this->getSkillBonus($this->Skills[$skill->OtherSkillName]->Name);
        }
        if (array_key_exists($skill->ClassName,$this->Classes)) {
            $classLevel = $this->Classes[$skill->ClassName]->Level;
        }
        return $baseSkillBonus + floor($classLevel / 2);
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
        //if this is a calculated skill, return whether the base skill can be performed
        if ($this->Skills[$skillName]->SkillClassLevelCaluclation) {
            return $this->canPerformSkill($this->Skills[$skillName]->OtherSkillName);
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
        $armorCheckApplies = [TRUE,FALSE,FALSE,TRUE,FALSE,FALSE,TRUE,FALSE,TRUE,TRUE,FALSE,FALSE,
        FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,
        FALSE,TRUE,FALSE,TRUE,FALSE,TRUE,FALSE,TRUE,FALSE];

        for ($i = 0; $i < count($skills); $i++)
        {
            $skill = new Skill($skills[$i],$skillAbilities[$i],$armorCheckApplies[$i]);
            $this->Skills[$skill->Name]=$skill;
        }

    }
}
