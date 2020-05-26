<?php

use Covid\Blog\Models\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Covid\Base\Models\User;
use Carbon\Carbon;

$factory->define(Article::class, function (Faker $faker) {
    $title = $faker->name;
    $author = factory(User::class)->create();

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'content' => $faker->paragraph,
        'author_id' => $author->id,
        'status' => Article::STATUS_PUBLISHED,
        'publish_at' => Carbon::now(),
        'thumbnail' => '',
        'meta_title' => $title,
        'meta_description' => $title,
    ];
});
