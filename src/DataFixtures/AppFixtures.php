<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
// Create fakes datas
    public function load(ObjectManager $manager)
    {
        // Faker Library
        $faker = Faker\Factory::create();

        // Create brands with a fake name generated by faker
        $brands = Array();
        for ($i = 0; $i < 4; $i++) {
            $brands[$i] = new Brand();
            $brands[$i]->setName($faker->company);
            $manager->persist($brands[$i]);
        }

        // Create categories
        $categories = Array();
        for ($i = 0; $i < 4; $i++) {
            $categories[$i] = new Category();

            // Use a switch to attribute a different name at each loop iteration
            // I create by myself the names, because faker have not the possibility to generate fake category names
            switch ($i) {
                case 0:
                    $categories[$i]->setName('Sport');
                    break;
                case 1:
                    $categories[$i]->setName('Livre');
                    break;
                case 2:
                    $categories[$i]->setName('VĂȘtements');
                    break;
                case 3:
                    $categories[$i]->setName('Parfum');
                    break;
            }
            $manager->persist($categories[$i]);
        }

        // Create false product with many datas generated by faker
        $product = Array();
        for ($i = 0; $i < 12; $i++) {
            $product[$i] = new Product();
            $product[$i]->setName($faker->word);
            $product[$i]->setActive(true);
            $product[$i]->setUrl('http://' . $product[$i]->getName() . '.com');
            $product[$i]->setDescription($faker->sentence($nbWords = 7, $variableNbWords = true));
            //Attribute a brand created upper
            $product[$i]->setBrand($brands[$i % 3]);
            //Attribute a category created upper
            $product[$i]->addCategory($categories[$i % 3]);

            $manager->persist($product[$i]);
        }
        // Finally send all these objects in database
        $manager->flush();
    }
}
