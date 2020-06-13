<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use App\Service\SlugifyService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        0 => [
            'name' => 'Norman Reedus',
            'program' => 'program_0'
        ],
        1 => [
            'name' => 'Andrew Lincoln',
            'program' => 'program_0',
        ],
        2 => [
            'name' => 'Danaï Gurira',
            'program' => 'program_0',
        ],
        3 => [
            'name' => 'Melissa MC Bride',
            'program' => 'program_0'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $slugify = new SlugifyService();
        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $faker  =  Faker\Factory::create('fr_FR');
            $actor->setName($faker->name());
            $actor->setSlug($slugify->generateSlugify($actor->getName()));
            $actor->addProgram($this->getReference('program_' . rand(0,5)));
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}
