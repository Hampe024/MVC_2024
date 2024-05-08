<?php

namespace App\Card;

class Card
{
    private int $value;
    private string $suite;
    private string $icon;

    public function __construct(int $value, string $suite, string $icon)
    {
        $this->value = $value;
        $this->suite = $suite;
        $this->icon = $icon;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getSuite(): string
    {
        return $this->suite;
        
    }

    public function getAsString(): string
    {
        return "{$this->icon}";
    }
}
