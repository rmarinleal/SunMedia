<?php

namespace SunMedia;

interface UserInterface
{
    public function gender(): string;

    public function device(): string;

    public function age(): int;
}
