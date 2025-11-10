<?php

$key = env('ENCRYPTION_KEY');

return [
    'key' => str_starts_with($key, 'base64:')
        ? base64_decode(substr($key, 7))
        : $key,
];
