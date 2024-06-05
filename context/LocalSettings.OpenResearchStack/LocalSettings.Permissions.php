<?php

$wgGroupPermissions['*']['read'] = false;
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['user']['delete'] = true;
$wgGroupPermissions['bot']['upload'] = true;
$wgGroupPermissions['bot']['editprotected'] = true;

# needed for ExternalData Extension,
# we call ourselves and retireve data, but the Extension does not handle Auth
if ( !isset( $_SERVER['REMOTE_ADDR'] ) OR $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ) {
    $wgGroupPermissions['*']['read'] = true;
    $wgGroupPermissions['*']['edit'] = true;
}
