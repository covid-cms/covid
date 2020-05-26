<?php

use Covid\Blog\Models\Article;

return [
    'article' => [
        'status' => [
            Article::STATUS_PUBLISHED,
            Article::STATUS_DRAFT,
        ]
    ]
];
