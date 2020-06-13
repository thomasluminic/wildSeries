<?php


namespace App\DataFixtures;


use App\Entity\Actor;
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
        for ($i = 0; $i < 50; $i++) {
            $program = new Actor();
            $faker  =  Faker\Factory::create('fr_FR');
            $program->setName($faker->name());
            $program->addProgram($this->getReference('program_' . rand(0,5)));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}
