<?php
/**
 * Created by PhpStorm.
 * User: fede
 * Date: 2019-02-21
 * Time: 21:40
 */

namespace Falvarez\Playground;

use Aws\S3\PostObjectV4;

class S3Client
{
    public const MINIO_ACCESS_KEY = "AKIAIOSFODNN7EXAMPLE";
    public const MINIO_SECRET_KEY = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY";

    public const MINIO_BUCKET_NAME = "test";

    public function getPresignedUrl(string $key, string $operation): string
    {
        $credentials = new \Aws\Credentials\Credentials(
            self::MINIO_ACCESS_KEY,
            self::MINIO_SECRET_KEY
        );

        $credentialProvider = \Aws\Credentials\CredentialProvider::fromCredentials($credentials);

        $s3Client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => 'us-east-2',
            'endpoint' => 'http://localhost:8080',
            'use_path_style_endpoint' => true,
            'credentials' => $credentialProvider,
        ]);

        //Creating a presigned URL
        $cmd = $s3Client->getCommand($operation, [
            'Bucket' => self::MINIO_BUCKET_NAME,
            'Key' => $key
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string)$request->getUri();

        return $presignedUrl;
    }
}
