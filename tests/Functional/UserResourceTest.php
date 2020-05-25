<?php


namespace App\Tests\Functional;


use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UserResourceTest extends  CustomApiTestCase
{
    use ReloadDatabaseTrait;


    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'example@adab.tj',
                'username' => 'example',
                'password' => 'brie'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);

        $this->login($client, 'example@adab.tj', 'brie');

    }

    public function testUpdateUser()
    {
        $client = self::createClient();

        $user = $this->createUserAndLogin($client,'example@adab.tj', 'brie');

        $client->request('PUT','/api/users/'.$user->getId(), [
           'json' => [
               'username' => 'shamil'
           ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            'username' => 'shamil'
        ]);
    }
}
