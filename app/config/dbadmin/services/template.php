<?php

use Lagdo\UiBuilder;

// The "dialogs" options defined here override those in the Jaxon config file.
return [
    // SB Admin template: https://startbootstrap.com/template/sb-admin
    'sb-admin' => [
        'builder' => UiBuilder\Bootstrap5\Builder::class,
        'dialogs' => [
            'modal' => 'bootstrap5',
            'toast' => 'notyf',
            'alert' => 'sweetalert',
            'confirm' => 'sweetalert',
        ],
    ],
    // CoreUI 5 template: https://coreui.io/product/free-bootstrap-admin-template/
    'coreui5' => [
        'builder' => UiBuilder\Bootstrap5\CoreUi\Builder::class,
        'dialogs' => [
            'modal' => 'bootstrap5',
            'toast' => 'notyf',
            'alert' => 'sweetalert',
            'confirm' => 'sweetalert',
        ],
    ],
    // Plain Admin template: https://plainadmin.com/
    'plain-admin' => [
        'builder' => UiBuilder\Bootstrap5\Builder::class,
        'dialogs' => [
            'modal' => 'bootstrap5',
            'toast' => 'notyf',
            'alert' => 'sweetalert',
            'confirm' => 'sweetalert',
        ],
    ],
    // Bulma Admin One template: https://github.com/vikdiesel/admin-one-bulma-dashboard
    'bulma' => [
        'builder' => UiBuilder\Bulma\Builder::class,
        'dialogs' => [
            'modal' => 'bulma',
            'toast' => 'notyf',
            'alert' => 'cute',
            'confirm' => 'cute',
        ],
    ],
];
