<?php


namespace App\Tests\Functional;



use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class PoemResourceTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreatePoemListening()
    {
        $client = self::createClient();

        $client->request('POST', '/api/poems', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $user = new User();

        $user->setEmail('study_test@exaple.com');
        $user->setUsername('study_test');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$U8fZcRDvPFdBqS7xgVpSng$ukRQ2CJjV23bRsQ3nLlHxBTYuyCcCi/dTmgCbsjSbJI');

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST', 'login', [
           'headers' => ['Content-Type' => 'application/json'] ,
            'json' => [
                'email' => 'study_test@exaple.com',
                'password' => '123456'
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}
