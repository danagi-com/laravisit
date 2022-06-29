<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Namespace
    |--------------------------------------------------------------------------
    |
    | This value informs Laravist which namespace you will be
    | selecting to get the user model instance
    | If this value equals to null, "\Coderflex\Laravisit\Models\User" will be used
    | by default.
    |
    */
    'user_namespace' => "\Coderflex\Laravisit\Models\User",

    /*
    |--------------------------------------------------------------------------
    | User Namespace
    |--------------------------------------------------------------------------
    |
    | This value tells Laravist what types of visits there are.
    | For example, a model can be visited, appear in a list, or be found via a
    | search query.
    | The first type is used as the default.
    |
    */
    'visit_types' => [
        'visit',
        'list',
        'search',
    ],
];
