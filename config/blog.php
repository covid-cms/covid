<?php

use App\Models\Blog\Article;

return [
    'article' => [
        'status' => [
            Article::STATUS_PUBLISHED,
            Article::STATUS_DRAFT,
        ]
    ]
];
