<?php

$parentBreadcrumbs = [['name' => 'Transparency Management'], ['name' => 'Account Config', 'url' => '']];

return [
    'breadcrumbs' => [
        'list' => [
            ...$parentBreadcrumbs,
            ['name' => 'Listing']
        ],
        'create' => [
            ...$parentBreadcrumbs,
            'Create'
        ],
        'edit' => [
            ...$parentBreadcrumbs,
            'Edit'
        ]
    ]
];