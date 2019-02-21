<?php
/**
 * Created by PhpStorm.
 * User: fede
 * Date: 2019-02-21
 * Time: 21:40
 */

namespace Falvarez\Playground\Tests;

use Falvarez\Playground\S3Client;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class s3ClientTest extends TestCase
{
    public function testPut()
    {
        $key = 'image.jpg';

        $s3Client = new S3Client();
        $presignedUrl = $s3Client->getPresignedUrl($key, 'PutObject');

        $client = new Client();

        $response = $client->request('PUT', $presignedUrl, [
            'body' => fopen(__DIR__ . "/resources/$key", 'r')
        ]);

        $this->assertSame(200, $response->getStatusCode());

        $presignedUrl = $s3Client->getPresignedUrl($key, 'GetObject');

        $client = new Client();

        $response = $client->request('GET', $presignedUrl);

        $this->assertSame(file_get_contents(__DIR__ . "/resources/$key"), (string) $response->getBody());
    }
}
