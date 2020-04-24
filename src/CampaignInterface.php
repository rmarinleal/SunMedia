<?php

namespace SunMedia;

interface CampaignInterface
{
    public function id(): int;

    public function gender(): string;

    public function priority(): string;

    public function device(): string;

    public function ageSegment(): string;
}
