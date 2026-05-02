<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase / Firestore Configuration
    |--------------------------------------------------------------------------
    |
    | Simpan file service account Firebase di:
    | storage/app/firebase/firebase_credentials.json
    |
    */

    'credentials' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase/firebase_credentials.json')),

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'sync_enabled' => env('FIREBASE_SYNC_ENABLED', true),
];
