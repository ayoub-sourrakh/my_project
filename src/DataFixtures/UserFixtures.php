<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setLastName('Doe' . $i);
            $user->setFirstName('John' . $i);
            $user->setEmail('john' . $i . '@example.com');

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'securepassword');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }

}
