<?php

namespace App\DataFixtures;

use App\Entity\ShoppingList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ShoppingListFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i<=10;$i++) {
            $shoppingList = new ShoppingList();
            $shoppingList->setName($faker->words(2, true));
            $manager->persist($shoppingList);
        }

        $manager->flush();
    }
}
