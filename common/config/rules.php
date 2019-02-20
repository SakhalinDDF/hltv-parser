<?php

declare(strict_types=1);

return [
    /**
     * Api routes
     */
    [
        'name'    => 'api-default-view',
        'pattern' => '<module:api>/<controller:[\w-]+>/<id:\d+>',
        'route'   => '<module>/<controller>/view',
        'verb'    => ['GET'],
    ],
    [
        'name'    => 'api-default-create',
        'pattern' => '<module:api>/<controller:[\w-]+>',
        'route'   => '<module>/<controller>/create',
        'verb'    => ['POST'],
    ],
    [
        'name'    => 'api-default-update',
        'pattern' => '<module:api>/<controller:[\w-]+>/<id:\d+>',
        'route'   => '<module>/<controller>/update',
        'verb'    => ['PUT'],
    ],
    [
        'name'    => 'api-default-delete',
        'pattern' => '<module:api>/<controller:[\w-]+>/<id:\d+>',
        'route'   => '<module>/<controller>/delete',
        'verb'    => ['DELETE'],
    ],

    ''                                    => 'site/index',
    '<controller:[\w-]+>'                 => '<controller>/index',
    '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
];
