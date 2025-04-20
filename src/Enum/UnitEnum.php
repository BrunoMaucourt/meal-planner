<?php

declare(strict_types=1);

namespace App\Enum;

enum UnitEnum: string
{
    case gram = 'gram';
    case kilogram = 'kilogram';
    case milliliter = 'milliliter';
    case liter = 'liter';
    case teaspoon = 'Teaspoon';
    case tablespoon = 'Tablespoon';
    case cup = 'Cup';
    case piece = 'Piece';
    case slice = 'Slice';
    case pinch = 'Pinch';
    case drop = 'Drop';

    public function enumToString(): string
    {
        return match($this) {
            self::gram => UnitEnum::gram->value,
            self::kilogram => UnitEnum::kilogram->value,
            self::milliliter => UnitEnum::milliliter->value,
            self::liter => UnitEnum::liter->value,
            self::teaspoon => UnitEnum::teaspoon->value,
            self::tablespoon => UnitEnum::tablespoon->value,
            self::cup => UnitEnum::cup->value,
            self::piece => UnitEnum::piece->value,
            self::slice => UnitEnum::slice->value,
            self::pinch => UnitEnum::pinch->value,
            self::drop => UnitEnum::drop->value,
        };
    }

    public function getUnit(): string
    {
        return match($this) {
            self::gram => 'g',
            self::kilogram => 'kg',
            self::milliliter => 'mL',
            self::liter => 'L',
            self::teaspoon => 'tsp',
            self::tablespoon => 'tbsp',
            self::cup => 'cup',
            self::piece => 'pcs',
            self::slice => 'slice',
            self::pinch => 'pinch',
            self::drop => 'drop',
        };
    }
}
