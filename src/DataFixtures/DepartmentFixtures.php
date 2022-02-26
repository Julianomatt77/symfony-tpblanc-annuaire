<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $department1 = new Department();
        $department1->setName('Recrutement');
        $department1->setColor('#18558f');
        $this->addReference('recrutement', $department1);
        $manager->persist($department1);

        $department2 = new Department();
        $department2->setName('Informatique');
        $department2->setColor('#ffb976');
        $this->addReference('informatique', $department2);
        $manager->persist($department2);

        $department3 = new Department();
        $department3->setName('Comptabilité');
        $department3->setColor('green');
        $this->addReference('comptabilite', $department3);
        $manager->persist($department3);

        $department4 = new Department();
        $department4->setName('Direction');
        $department4->setColor('red');
        $this->addReference('direction', $department4);
        $manager->persist($department4);

        $manager->flush();
    }
}
