<?php

namespace App\Enums;

enum ProductSort: string
{
    case DEFAULT = 'default';
    case RATING_ASC = 'rating-asc';
    case RATING_DESC = 'rating-desc';
    case PRICE_ASC = 'price-asc';
    case PRICE_DESC = 'price-desc';

    public function translateLabel(): string
    {
        return match ($this) {
            ProductSort::DEFAULT => __('Default sorting'),
            ProductSort::RATING_ASC => __('Sort by average rating: low to high'),
            ProductSort::RATING_DESC => __('Sort by average rating: high to low'),
            ProductSort::PRICE_ASC => __('Sort by price: low to high'),
            ProductSort::PRICE_DESC => __('Sort by price: high to low'),
        };
    }
}
