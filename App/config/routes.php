<?php
return [
    'admin-login'       => 'user/login',
    'logout'            => 'user/logout',

    'task/add'              => 'task/index',
    'task/edit/([0-9]+)'    => 'task/edit/$1',

    'page-([0-9]+)'     => 'site/index/$1',
    ''                  => 'site/index'
];