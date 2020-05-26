<?php


namespace App\Tests\Functional;


use App\Entity\User;
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
                'name' => 'Name example',
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
               'username' => 'shamil',
               'roles' => ['ROLE_ADMIN']
           ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            'username' => 'shamil'
        ]);

        $em = $this->getEntityManager();

        $user = $em->getRepository(User::class)->find($user->getId());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }


    public function testGetUser()
    {
        $client = self::createClient();

        $user = $this->createUser('example@adab.tj', 'brie');
        $this->createUserAndLogin($client,'authenticated@adab.tj','brie');

        $user->setName('Ivan Ivanov');
        $em = $this->getEntityManager();
        $em->flush();

        $client->request('GET','/api/users/'.$user->getId());
        $this->assertJsonContains([
            'username' => 'example'
        ]);

        $data = $client->getResponse()->toArray();
        $this->assertArrayNotHasKey('name', $data);

        // refresh the user & elevate
        $user = $em->getRepository(User::class)->find($user->getId());
        $user->setRoles(['ROLE_ADMIN']);
        $em->flush();

        $this->login($client, 'example@adab.tj', 'brie');

        $client->request('GET','/api/users/'.$user->getId());
        $this->assertJsonContains([
            'name' => 'Ivan Ivanov'
        ]);
    }
}
