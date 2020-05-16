<?php

use App\Models\Blog\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $title = $faker->name;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'parent_id' => 0,
        'meta_title' => $title,
        'meta_description' => $title,
        'description' => $title,
        'thumbnail' => $title,
    ];
});
