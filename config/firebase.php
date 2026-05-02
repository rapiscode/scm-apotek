<?php

return [
    'credentials' => str_starts_with((string) env('FIREBASE_CREDENTIALS', ''), DIRECTORY_SEPARATOR)
        ? env('FIREBASE_CREDENTIALS')
        : base_path(env('FIREBASE_CREDENTIALS', 'storage/app/firebase/firebase_credentials.json')),
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'sync_enabled' => env('FIREBASE_SYNC_ENABLED', false),
];