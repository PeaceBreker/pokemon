<?php


function SkillLogic($skill, $skillTags)
{
    foreach ($skill as $skills) {
        if (!in_array($skills, $skillTags)) {
            return false;
        }
    }
    return true;
}


?>