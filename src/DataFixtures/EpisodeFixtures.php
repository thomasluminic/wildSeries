<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            $faker  =  Faker\Factory::create('fr_FR');
            $episode->setNumber($i);
            $episode->setTitle($faker->title());
            $episode->setSynopsis($faker->text(150));
            $episode->setSeason($this->getReference('season_' . rand(0,49)));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

}
