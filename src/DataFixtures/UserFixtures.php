<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        $normalUser = $this->createNormalUser();
        $manager->persist($normalUser);

        $adminUser = $this->createAdminUser();
        $manager->persist($adminUser);

        $manager->flush();
    }

    protected function createNormalUser()
    {
        $user = new User();
        $user->setEmail('demo@aspireapp.com');
        $password = $this->passwordEncoder->encodePassword($user, 'pwd123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }

    protected function createAdminUser()
    {
        $user = new User();
        $user->setEmail('admin@aspireapp.com');
        $password = $this->passwordEncoder->encodePassword($user, 'adminpwd123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        return $user;
    }


}
