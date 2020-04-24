<?php

namespace SunMedia;

class Campaign implements CampaignInterface {

    public function id(): int {
        return rand(1, 100);
    }

    public function gender(): string {
        $gender = ['male', 'female', 'both'];
        return $gender[rand(0, 1)];
    }

    public function priority(): string {
        $priority = ['low', 'high'];
        return $priority[rand(0, 1)];
    }

    public function device(): string {
        $device = ['mobile', 'laptop', 'table'];
        return $device[rand(0, 2)];
    }

    public function ageSegment(): string {
        $ageSegment = ['18:25', '26:50', '51:100'];
        return $ageSegment[rand(0, 2)];
    }
}