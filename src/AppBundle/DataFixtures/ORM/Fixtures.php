<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Groups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        $group = new Groups();
        $group->setName('group1');


        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName('user'.$i);
            $user->setActif(1);
            $user->setEmail('user'.$i.'@test.com');
            $user->setFirstname('firstname'.$i);
            $user->setGroups($group);
             $manager->persist($user);
        }
        $manager->persist($group);
        $manager->flush();
    }
}