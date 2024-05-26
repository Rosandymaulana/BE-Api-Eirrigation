<?php

namespace App;

use Google\Cloud\Storage\StorageClient;


class FirebaseStorage
{
    public static function initialize()
    {
        return new StorageClient([
            'projectId' => 'irrigation-upload-dump',
            'keyFilePath' => __DIR__ . '/../firebase_credential.json'
        ]);
    }
}
