<?php


namespace App\Tests\Functional;


use App\Entity\Poem;
use App\Entity\PoetImage;
use App\Entity\User;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class PoemResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreatePoem()
    {
        $client = self::createClient();

        $client->request('POST', '/api/poems', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $authenticatedUser = $this->createUserAndLogin($client,'studytest@adab.tj', '123456');
        $otherUser = $this->createUser('otheruser@adab.tj','123456');

        $poemData = [
            'name' => 'New poem test',
            'text' => 'Imrooz fardo'
        ];

        $client->request('POST', '/api/poems', [
            'json' => $poemData,
        ]);
        $this->assertResponseStatusCodeSame(201);


        $client->request('POST', '/api/poems', [
            'json' => $poemData + ['owner' => '/api/users/'.$otherUser->getId()],
        ]);
        $this->assertResponseStatusCodeSame(400, 'not passing the correct owner');

        $client->request('POST', '/api/poems', [
            'json' => $poemData + ['owner' => '/api/users/'.$authenticatedUser->getId()],
        ]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdatePoem()
    {
        $client = self::createClient();
        $user1 = $this->createUser('user1@adab.tj', '123456');
        $user2 = $this->createUser('user2@adab.tj', '123456');

        $poem = new Poem();
        $poem
            ->setOwner($user1)
            ->setName('Шери Бухоро')
            ->setText('Бӯи Ҷӯи Мӯлиён ояд ҳаме,
                            Ёди ёри меҳрубон ояд ҳаме.
                            Реги Омуву дурушти роҳи ӯ,
                            Зери поям парниён ояд ҳаме.
                            ')
            ->setDescription('Боре Наср ибни Аҳмад ба Ҳирот сафар кард. 
            Ба сабаби хушии обу ҳаво ва зебоии табиати ӯ чор сол он ҷо монда, 
            пойтахти худ шаҳри Бухороро гуё аз ёд баровард.
            Вазирону сарлашкарони ӯ, ки муштоқи ёру диёр ва пазмони аёлу фарзандон буданд,
            майли Бухоро доштанд. Азбаски замони осоишта буд, амир аз фароғат даст намекашид.')
            ->setIsPublished(true)
        ;

        $em = $this->getEntityManager();

        $em->persist($poem);
        $em->flush();


        $this->login($client, 'user2@adab.tj', '123456');
        $client->request('PUT', 'api/poems/'.$poem->getId(), [
            'json' => [
                'name' => 'Update user2',
                'owner' => 'api/users/'.$user2->getId()
            ]
        ]);

        $this->assertResponseStatusCodeSame(403, 'only author can updated');

        $this->login($client, 'user1@adab.tj', '123456');
        $client->request('PUT', 'api/poems/'.$poem->getId(), [
            'json' => [
                'name' => 'Update Bukhara 1'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);

    }

    public function testGetPoemCollection()
    {
        $client = self::createClient();
        $user = $this->createUser('shamil1@adab.tj', '123456');

        $poem1 = new Poem();
        $poem1->setOwner($user);
        $poem1->setName('Bait 1');
        $poem1->setText('If you can do it...');

        $poem2 = new Poem();
        $poem2->setOwner($user);
        $poem2->setName('Bait 2');
        $poem2->setText('If you can do it...');
        $poem2->setIsPublished(true);

        $poem3 = new Poem();
        $poem3->setOwner($user);
        $poem3->setName('Bait 3');
        $poem3->setText('If you can do it...');
        $poem3->setIsPublished(true);

        $em = $this->getEntityManager();
        $em->persist($poem1);
        $em->persist($poem2);
        $em->persist($poem3);
        $em->flush();

        $client->request('GET', '/api/poems');
        $this->assertResponseStatusCodeSame(200);
//        $this->assertJsonContains(['hydra:totalItems' => 3]);
    }

    public function testGetPoemItem()
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client,'shamil1@adab.tj', '123456');

        $poem1 = new Poem();
        $poem1->setOwner($user);
        $poem1->setText('If you can do it...');
        $poem1->setIsPublished(false);

        $em = $this->getEntityManager();
        $em->persist($poem1);
        $em->flush();

        $client->request('GET', '/api/poems/'.$poem1->getId());
        $this->assertResponseStatusCodeSame(404);

        $client->request('GET', '/api/users/'.$user->getId());
        $data = $client->getResponse()->toArray();
        $this->assertEmpty($data['poems']);
    }
}
