<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // creation de l'admin !
        $user = new User();
        $user->setEmail('admin@api.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();

        {
            // creation 9 utilisateurs! Bam!
            for ($i = 1; $i < 9; $i++) {
                $userGroup = new User();
                $userGroup->setEmail('user'.$i.'@api.com');
                $userGroup->setRoles(['ROLE_USER']);
                $password = $this->encoder->encodePassword($userGroup, 'user');
                $userGroup->setPassword($password);
                $manager->persist($userGroup);
                $manager->flush();
            }
    
            $manager->flush();
        }

    }
}
