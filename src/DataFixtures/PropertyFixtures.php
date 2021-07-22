<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Images;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($nbProperty = 1; $nbProperty <= 10; $nbProperty++) {
            $user = $this->getReference('user_' . $faker->numberBetween(1, 19));


            $property = new Property();
            $property->setUsers($user);

            $property->setTitle($faker->realText(20));
            $property->setDescription($faker->realText(300));
            $property->setAdress($faker->address);
            $property->setArea($faker->numberBetween(10, 500));
            $property->setRooms($faker->numberBetween(2, 10));
            $property->setBedrooms($faker->numberBetween(1, 9));
            $property->setPrice($faker->numberBetween(100, 900000));

            $property->setCity($faker->city);
            $property->setSold($faker->numberBetween(0, 1));

            // On uploade et on génère les images
            for ($image = 1; $image <= 2; $image++) {

                $img = 'public/uploads/images1.jpg';
                $imageProperty = new Images();
                $nomimage = str_replace('public/uploads/', '', $img);
                $imageProperty->setName($nomimage);
                $property->addImage($imageProperty);
            }
            $manager->persist($property);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            UsersFixtures::class
        ];
    }
}
