<?php

return [
    // can be any of:
    // public - main publicnet horizon server
    // test - test network
    // custom - must also set STELLAR_CUSTOM_URL via ENV or config
    'stellar_network' => ENV('STELLAR_NETWORK', 'public'),
    'stellar_custom_url' => ENV('STELLAR_CUSTOM_URL', null),

];
