<?php


namespace App\DataFixtures;


use App\Entity\Poem;
use App\Entity\Poet;
use App\Entity\PoetImage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class PoetFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager) : void
    {

        $poem = new Poem();
        $poem
            ->setOwner($manager->getReference(User::class, 4))
            ->setName('ШеЪри Бухоро')
            ->setText('Бӯи Ҷӯи Мӯлиён ояд ҳаме,
                            Ёди ёри меҳрубон ояд ҳаме.
                            Реги Омуву дурушти роҳи ӯ,
                            Зери поям парниён ояд ҳаме.
                            Оби Ҷайҳун бо ҳама паҳноварӣ
                            Хинги моро то миён ояд ҳаме.
                            Э, Бухоро, шод бошу дер зӣ,
                            Мир наздат шодмон ояд ҳаме.
                            Мир моҳ асту Бухоро осмон,
                            Моҳ сӯи осмон ояд ҳаме.
                            Мир сарв асту Бухоро бӯстон,
                            Сарв сӯи бӯстон ояд ҳаме.
                            Офарину мадҳ суд ояд ҳаме,
                            Гар ба ганҷ андар зиён ояд ҳаме.
                            ')
            ->setDescription('Боре Наср ибни Аҳмад ба Ҳирот сафар кард. 
            Ба сабаби хушии обу ҳаво ва зебоии табиати ӯ чор сол он ҷо монда, 
            пойтахти худ шаҳри Бухороро гуё аз ёд баровард.
            Вазирону сарлашкарони ӯ, ки муштоқи ёру диёр ва пазмони аёлу фарзандон буданд,
            майли Бухоро доштанд. Азбаски замони осоишта буд, амир аз фароғат даст намекашид.
            Онҳо аз устод Рӯдакӣ мадад ҷустанд, ки чорагарӣ кунад. Рӯдакӣ ба доди онҳо расид.
            Вай дар васфи Бухоро қасидае навишта, бо самимият, ташбеҳу муболиға шеъри гӯшнавозе эҷод кард.'
            )
        ;

        $image = new PoetImage();
        $image
            ->setTitle('Сурати Устод')
            ->setSrc('rudaki.jpg')
        ;

        $poetEntity = new Poet();
        $poetEntity
            ->addPoetImage($image)
            ->addPoem($poem)

            ->setName('Рудаки')
            ->setSurname('Абуабдуллоҳ')
            ->setFullName('Абуабдуллоҳ Ҷаъфар ибни Муҳаммад ибни Ҳаким ибни Абдураҳмон ибни Одам Рӯдакӣ')
            ->setShortInfo('Бунёдгузори адаби форсӣ,
            нахустин шоъири машҳури порсисарои Эронзамин дар давраи Сомониён аст.')
            ->setBiography('Бунёдгузори адаби форсӣ,
            нахустин шоъири машҳури порсисарои Эронзамин дар давраи Сомониён аст.
            Бунёдгузори адаби форсӣ,
            нахустин шоъири машҳури порсисарои Эронзамин дар давраи Сомониён аст.
            ')
            ->setDateBirth(DateTimeImmutable::createFromFormat('Y-m-d|', '860-12-31'))
            ->setDateDeath(DateTimeImmutable::createFromFormat('Y-m-d|', '941-12-31'))
        ;
        $manager->persist($poetEntity);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
        ];
    }

    public static function getGroups() : array
    {
        return ['dev'];
    }
}
