<?php

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testUserAttributes()
    {
        $user = new User();
        $user->setLastName('Doe');
        $user->setFirstName('John');
        $user->setEmail('john@example.com');
        $user->setPassword('securepassword');
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertEquals('securepassword', $user->getPassword());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testUserRole()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }
}
