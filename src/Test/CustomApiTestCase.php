<?php


namespace App\Test;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CustomApiTestCase extends ApiTestCase
{
    protected function createUser(string $email, string $password): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setUsername(substr($email,0, strpos($email, '@')));
        $user->setName(substr($email,0, strpos($email, '@')));

        $password = self::$container->get('security.password_encoder')->encodePassword($user, $password);
        $user->setPassword($password);

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function login(Client $client, string $email, string $password)
    {
        $client->request('POST', 'login', [
            'json' => [
                'email' => $email,
                'password' => $password
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    }

    protected function createUserAndLogin(Client $client, string $email, string $password)
    {
        $user = $this->createUser($email, $password);

        $this->login($client, $email, $password);

        return $user;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManager();
    }

}
