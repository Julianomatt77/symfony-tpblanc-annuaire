<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;


    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this -> hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('user1@deloitte.com');
        $user1->setPassword($this->hasher->hashPassword($user1, 'user123@'));
        $user1 -> setFirstname('juju');
        $user1 -> setLastname('Le Tordu');
        $user1 -> setPicture('user1.png');
        $user1 -> setDepartment($this->getReference('informatique'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('admin@deloitte.com');
        $user2->setPassword($this->hasher->hashPassword($user1, 'admin123@'));
        $user2 -> setFirstname('Jeanette');
        $user2 -> setLastname('La folle');
        $user2 -> setPicture('admin1.jpg');
        $user2 -> setDepartment($this->getReference('direction'));
        $user2->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DepartmentFixtures::class
        ];
    }
}
