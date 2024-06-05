<?php

$settings = [ 
    'Debug',
    'Permissions',
    'Extensions',
    'Settings',
    'Namespaces'
];

foreach ( $settings as $setting ) {
    require_once( "$IP/LocalSettings.OpenResearchStack/LocalSettings.$setting.php" );
}
