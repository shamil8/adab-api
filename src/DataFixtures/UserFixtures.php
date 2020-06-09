<?php


namespace App\DataFixtures;


use App\Constants\RoleConstants;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager) : void
    {
        /**
         * User default role admin
         */
        $user = new User();
        $user->setEmail('debug@adab.tj');
        $user->setName('Debug Developer');
        $user->setUsername('debug');
        $user->setRoles([RoleConstants::DEBUG]);

        $password = $this->encoder->encodePassword($user, 'debug');
        $user->setPassword($password);

        $manager->persist($user);

        /**
         * User default role admin
         */
        $user = new User();
        $user->setEmail('admin@adab.tj');
        $user->setName('Admin');
        $user->setUsername('admin');
        $user->setRoles([RoleConstants::ADMIN]);

        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);

        $manager->persist($user);

        /**
         * User default role moderator
         */
        $user = new User();
        $user->setEmail('moderator@adab.tj');
        $user->setUsername('moderator');
        $user->setName('Moderator');
        $user->setRoles([RoleConstants::MODERATOR]);

        $password = $this->encoder->encodePassword($user, 'moderator');
        $user->setPassword($password);

        $manager->persist($user);

        /**
         * User default role user
         */
        $user = new User();
        $user->setEmail('user@adab.tj');
        $user->setUsername('user');
        $user->setName('User Userov');
        $password = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }

    public static function getGroups() : array
    {
        return ['dev'];
    }
}
