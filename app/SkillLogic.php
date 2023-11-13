<?php


function SkillLogic($skill, $skillTags)
{
    foreach ($skill as $skills) {
        if (!in_array($skills, $skillTags)) {
            //判斷是否是可以學習技能，如果不行return false
            return false;
        }
    }
    //如果可以，return true
    return true;
}


?>