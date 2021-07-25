<?php

namespace App\DataFixtures;

use App\Entity\PropertyType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = [
            1 => [
                'name' => 'appartement'
            ],
            2 => [
                'name' => 'maison',
            ],
            3 => [
                'name' => 'terrain constructible',
            ],
            4 => [
                'name' => 'studio',
            ],
            5 => [
                'name' => 'parking',
            ],
            6 => [
                'name' => 'local professionnel',
            ],
            7 => [
                'name' => 'terrain non constructible',
            ],
        ];

        foreach ($types as $key => $value) {
            $propertytype = new PropertyType();
            $propertytype->setName($value['name']);

            $manager->persist($propertytype);

            // Enregistre la propertytype dans une référence
            $this->addReference('propertytype_' . $key, $propertytype);
        }
        $manager->flush();
    }
}
