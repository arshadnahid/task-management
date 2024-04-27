<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCategoriesId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            $categoryIds = json_decode($value, true);
            foreach ($categoryIds as $categoryId) {
                if (!Category::where('id', $categoryId)->exists()) {
                    $fail('The selected categories are invalid.');
                }
            }
        }


    }
}
