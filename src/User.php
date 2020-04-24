<?php

namespace SunMedia;

class User implements UserInterface {

    public function gender(): string{
        $gender = ['male', 'female'];
        return $gender[rand(0, 1)];
    }

    public function device(): string {
        $device = ['mobile', 'laptop', 'table'];
        return $device[rand(0, 2)];
    }

    public function age(): int {
        return rand(18, 64);
    }
}
