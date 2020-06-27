<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    $itemNames = [
        'Potassium Cartridge',
        'Pipette tips',
        'Tosoh Filters',
        'Tosoh Buffer',
        'Preclean Cobas',
        'Procell E411',
        'Cleancell E411',
        'Procell Cobas',
        'Cleancell Cobas',
    ];
    return [
        'name'=>$faker->randomElement($itemNames),
        'price'=>rand(100, 4500),
        'lawson_number'=> Str::random(5) 
    ];
});
