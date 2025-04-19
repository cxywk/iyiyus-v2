<?php

return [
    'autoload' => false,
    'hooks' => [
        'action_begin' => [
            'clicaptcha',
        ],
        'view_filter' => [
            'clicaptcha',
        ],
        'captcha_mode' => [
            'clicaptcha',
        ],
    ],
    'route' => [],
    'priority' => [],
    'domain' => '',
];
