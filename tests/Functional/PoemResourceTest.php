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

    public function testCreatePoemListening()
    {
        $client = self::createClient();

        $client->request('POST', '/api/poems', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogin($client,'studytest@adab.tj', '123456');

        $client->request('POST', '/api/poems', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(400);
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
}
