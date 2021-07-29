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

        for ($nbProperty = 1; $nbProperty <= 20; $nbProperty++) {
            $user = $this->getReference('user_' . $faker->numberBetween(1, 19));
            $propertytype = $this->getReference('propertytype_' . $faker->numberBetween(1, 7));

            $property = new Property();
            $property->setUsers($user);
            $property->setPropertytype($propertytype);


            $property->setTitle($faker->realText(20));
            $property->setDescription($faker->realText(300));
            $property->setAdress($faker->address);
            $property->setArea($faker->numberBetween(10, 500));
            $property->setRooms($faker->numberBetween(2, 10));
            $property->setBedrooms($faker->numberBetween(1, 9));
            $property->setPrice($faker->numberBetween(100, 900000));
            $property->setEnergy('solaire');
            $property->setPhone($faker->phoneNumber());
            $property->setCity($faker->city);
            $property->setPostcode($faker->postcode);
            $property->setSold($faker->numberBetween(0, 1));
            $property->setActive(true);


            // On uploade et on génère les images
            for ($k = 1; $k <= rand(1, 6); $k++) {

                // $rand = rand(1, 3);
                $img = 'public/uploads/image' . rand(1, 6) . '.jpg';
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
