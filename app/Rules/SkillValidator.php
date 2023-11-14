<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Skill;

class SkillValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 分割以逗号分隔的技能 ID
        // 遍历技能 ID，检查是否存在于 skills 表中
        foreach ($value as $skillId) {
            $exists = Skill::where('id', $skillId)->exists();

            // 如果有任何一个技能 ID 不存在于 skills 表中，返回 false
            if (!$exists) {
                $fail('One or more skill IDs do not exist.');
            }
    }
}
}