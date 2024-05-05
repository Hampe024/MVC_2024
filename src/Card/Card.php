<?php

namespace App\Card;

class Card
{
    protected int $value;
    protected string $suite;
    protected string $icon;

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
        return;
    }

    public function getAsString(): string
    {
        return "{$this->icon}";
    }
}
