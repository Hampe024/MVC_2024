<?php

namespace App\Card;

class Card
{
    protected $value;
    protected $suite;
    protected $icon;

    public function __construct($value, $suite, $icon)
    {
        $this->value = $value;
        $this->suite = $suite;
        $this->icon = $icon;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "{$this->icon}";
    }
}
