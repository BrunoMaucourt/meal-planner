<?php

declare(strict_types=1);

namespace App\Enum;

enum MealTypeEnum: string
{
    case omnivore = 'Omnivore';
    case vegetarian = 'Vegetarian';
    case vegan = 'Vegan';
    case pescatarian = 'Pescatarian';
    case glutenFree = 'Gluten free';
    case dairyFree = 'Dairy free';
    case lowCarb = 'Low carb';
    case highProtein = 'High protein';
    case keto = 'Keto';
    case paleo = 'Paleo';

    public function enumToString(): string
    {
        return match($this) {
            self::omnivore => MealTypeEnum::omnivore->value,
            self::vegetarian => MealTypeEnum::vegetarian->value,
            self::vegan => MealTypeEnum::vegan->value,
            self::pescatarian => MealTypeEnum::pescatarian->value,
            self::glutenFree => MealTypeEnum::glutenFree->value,
            self::dairyFree => MealTypeEnum::dairyFree->value,
            self::lowCarb => MealTypeEnum::lowCarb->value,
            self::highProtein => MealTypeEnum::highProtein->value,
            self::keto => MealTypeEnum::keto->value,
            self::paleo => MealTypeEnum::paleo->value,
        };
    }
}
