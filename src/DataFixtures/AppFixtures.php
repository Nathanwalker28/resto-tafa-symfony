<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Dish;    
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use FakerRestaurant\Provider\fr_FR\Restaurant;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $faker->addProvider(new Restaurant($faker));

        

        for ($i = 0; $i < 20; $i++) {
            $dish = new Dish();
            $dish->setName($faker->foodName());
            $dish->setDescription($faker->sentence());
            $dish->setIngredients(join(', ', $faker->words()));
            $dish->setPrice($faker->randomNumber(3));
            $dish->setCoverImage($faker->imageUrl(500, 500));
            $dish->setCreateAt(new \Datetime());
            $manager->persist($dish);
        }
        $manager->flush();
    }
}
