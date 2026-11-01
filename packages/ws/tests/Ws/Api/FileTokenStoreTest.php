<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Api;

use DateTime;
use Greenter\Api\ApiFactory;
use Greenter\Api\FileTokenStore;
use Greenter\Services\Api\BasicToken;
use Greenter\Sunat\GRE\Api\AuthApiInterface;
use Greenter\Sunat\GRE\Model\ApiToken;
use GuzzleHttp\ClientInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class FileTokenStoreTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        $this->dir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'greenter-token-test-'.bin2hex(random_bytes(6));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        if (!is_dir($this->dir)) {
            return;
        }
        foreach (glob($this->dir.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
            unlink($file);
        }
        rmdir($this->dir);
    }

    public function testGetMissingToken(): void
    {
        $store = new FileTokenStore($this->dir);

        $this->assertNull($store->get('client-id'));
        $this->assertDirectoryDoesNotExist($this->dir);
    }

    public function testSetAndGet(): void
    {
        $expire = new DateTime('+1 hour');
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('xxxx.yyyy.zzzz', $expire));

        $token = (new FileTokenStore($this->dir))->get('client-id');

        $this->assertNotNull($token);
        $this->assertEquals('xxxx.yyyy.zzzz', $token->getValue());
        $this->assertEquals($expire->getTimestamp(), $token->getExpire()->getTimestamp());
        $this->assertNull($store->get('other-client-id'));
    }

    public function testOverwriteToken(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('first', new DateTime('+1 hour')));
        $store->set('client-id', new BasicToken('second', new DateTime('+1 hour')));

        $this->assertEquals('second', $store->get('client-id')->getValue());
        $this->assertCount(1, glob($this->dir.DIRECTORY_SEPARATOR.'*'));
    }

    public function testExpiredToken(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('xxxx', new DateTime('-1 minute')));

        $this->assertNull($store->get('client-id'));
    }

    public function testTokenWithoutExpireIsNotStored(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('xxxx', new DateTime('+1 hour')));
        $store->set('client-id', new BasicToken('yyyy', null));

        $this->assertNull($store->get('client-id'));
    }

    public function testInvalidContent(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('xxxx', new DateTime('+1 hour')));
        $files = glob($this->dir.DIRECTORY_SEPARATOR.'*');
        file_put_contents($files[0], '{invalid json');

        $this->assertNull($store->get('client-id'));
    }

    public function testFileDoesNotExposeId(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client/../id', new BasicToken('xxxx', new DateTime('+1 hour')));

        $files = glob($this->dir.DIRECTORY_SEPARATOR.'*');
        $this->assertCount(1, $files);
        $this->assertStringNotContainsString('client', basename($files[0]));
        $this->assertEquals('xxxx', $store->get('client/../id')->getValue());
    }

    /**
     * @requires OSFAMILY Linux
     */
    public function testFilePermissions(): void
    {
        $store = new FileTokenStore($this->dir);
        $store->set('client-id', new BasicToken('xxxx', new DateTime('+1 hour')));

        $files = glob($this->dir.DIRECTORY_SEPARATOR.'*');
        $this->assertEquals('0600', substr(sprintf('%o', fileperms($files[0])), -4));
        $this->assertEquals('0700', substr(sprintf('%o', fileperms($this->dir)), -4));
    }

    public function testTokenReusedAcrossFactories(): void
    {
        $auth = Mockery::mock(AuthApiInterface::class);
        $auth->shouldReceive('getToken')
            ->once()
            ->andReturn(new ApiToken([
                'access_token' => 'xxxx.xxxx.xxxx',
                'token_type' => 'JWT',
                'expires_in' => 3600,
            ]));
        $client = Mockery::mock(ClientInterface::class);

        // Simula dos peticiones/procesos distintos que comparten el directorio.
        (new ApiFactory($auth, $client, new FileTokenStore($this->dir), null))
            ->create('x', 'x', '20123456780MODDATOS', 'moddatos');
        (new ApiFactory($auth, $client, new FileTokenStore($this->dir), null))
            ->create('x', 'x', '20123456780MODDATOS', 'moddatos');

        $this->assertEquals('xxxx.xxxx.xxxx', (new FileTokenStore($this->dir))->get('x')->getValue());
    }
}
