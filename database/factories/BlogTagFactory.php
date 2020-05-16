<?php

use App\Models\Blog\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    $title = $faker->name;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'meta_title' => $title,
        'meta_description' => $title,
        'description' => $title,
        'thumbnail' => $title,
    ];
});
