<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
      'Action',
      'Aventure',
      'Animation',
      'Fantastique',
      'Horreur',
      'Guerre',
      'Fais réel',
    ];
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::CATEGORIES as $key => $categoryName ) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('categorie_' . $i, $category);
            $i++;
        }
        $manager->flush();
    }
}
