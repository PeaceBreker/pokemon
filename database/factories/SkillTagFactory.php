<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkillTag>
 */
class SkillTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $raceId = 1; // 初始化 race_id
    protected $num = 0;

    public function definition(): array
    {
        $this->num ++ ;
        return [
            'race_id' => $this->raceId, // 使用当前的 race_id
            'skill_id' => $this->num, // 生成 1 到 4 之间的不同 skill_id
            // 其他字段的定义
        ];
    }

    public function forRaceId($raceId)
    {
        return $this->state(function (array $attributes) use ($raceId) {
            return [
                'race_id' => $raceId,
            ];
        });
    }
}
