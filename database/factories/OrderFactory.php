<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'product_id'=>1,
        'quantity'=>rand(1,20),
        'due_date'=> Carbon::parse('+1 week'),
    ];
});
