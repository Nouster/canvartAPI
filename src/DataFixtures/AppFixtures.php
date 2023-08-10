<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\CategoryNFT;
use App\Entity\CollectionNFT;
use App\Entity\NFT;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const NBCATEGORY = 7;
    const NBCOLLECTION = 10;
    const NBADDRESS = 3;
    const NBNFT = 10;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $categories = [];
        for ($i = 0; $i < self::NBCATEGORY; $i++) {

            $category = new CategoryNFT();
            $category->setName($faker->word());
            $category->setDescription($faker->paragraph());
            $manager->persist($category);
            $categories[] = $category;
        }


        $collections = [];
        for ($i = 0; $i < self::NBCOLLECTION; $i++) {
            $collection = new CollectionNFT();
            $collection->setName($faker->word());
            $manager->persist($collection);
            $collections[] = $collection;
        }

        $addresses = [];
        for ($i = 0; $i < self::NBADDRESS; $i++) {
            $address = new Address();
            $address->setStreet($faker->sentence())
                ->setZipCode($faker->randomNumber(4))
                ->setCity($faker->word())
                ->setCountry(($faker->word()));
            $manager->persist($address);
            $addresses[] = $address;
        }

        $userAdmin = new User();
        $userAdmin->setEmail('test@gmail.com')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->hasher->hashPassword($userAdmin, 'test'))
            ->setAddress($faker->randomElement($addresses))
            ->setFirstname('Taty')
            ->setLastname('Jozy')
            ->setGender("female")
            ->setBirthdate(new DateTime(1970 - 01 - 01));
        $manager->persist($userAdmin);
        $users[] = $userAdmin;

        $userRegular = new User();
        $userRegular->setEmail('testRegularUser@gmail.com')
            ->setPassword($this->hasher->hashPassword($userRegular, 'test'))
            ->setAddress($faker->randomElement($addresses))
            ->setFirstname('Mohamed')
            ->setLastname('Djebali')
            ->setGender("male")
            ->setBirthdate(new DateTime(1990 - 20 - 10));
        $manager->persist($userRegular);
        $users[] = $userRegular;

        $nfts = [];
        for ($i = 0; $i < self::NBNFT; $i++) {
            $nft = new NFT();
            $nft->setName($faker->word())
                ->setImg($faker->url())
                ->setDescription($faker->paragraph())
                ->setLaunchDate((new DateTime()))
                ->setLaunchPriceEth($faker->randomFloat())
                ->setLaunchPriceEuro($faker->randomFloat())
                ->setCreator($faker->name())
                ->setCollectionNFT($faker->randomElement($collections))
                ->addCategoryNFT($faker->randomElement($categories));

            $manager->persist($nft);
            $nfts[] = $nft;
        }

        $manager->flush();
    }
}
