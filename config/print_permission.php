<?php

return [

    \App\Helpers\Acl::PERMISSION_ENV_ROLES => [
        \App\Helpers\Acl::OPERATION_C => true,
        \App\Helpers\Acl::OPERATION_U => true,
        \App\Helpers\Acl::OPERATION_D => true,
    ],

    \App\Helpers\Acl::PERMISSION_ENV_USERS => [
        \App\Helpers\Acl::OPERATION_C => true,
        \App\Helpers\Acl::OPERATION_U => true,
        \App\Helpers\Acl::OPERATION_D => true,
    ],

];
