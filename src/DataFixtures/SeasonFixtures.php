<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $season = new Season();
            $faker  =  Faker\Factory::create('fr_FR');
            $season->setNumber($i);
            $season->setDescription($faker->text(150));
            $season->setYear($faker->year());
            $season->setProgram($this->getReference('program_'. rand(0,5)));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $manager->flush();
    }
}
