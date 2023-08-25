<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $client->submitForm('login', [
            '_username' => 'john@example.com',
            '_password' => 'securepassword',
        ]);

        // $this->assertResponseRedirects('/');

        $this->assertResponseRedirects();
        $location = $client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/', $location);
    }

    public function testLoginFailure()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $client->followRedirects();

        $client->submitForm('login', [
            '_username' => 'john@example.com',
            '_password' => 'wrongpassword',
        ]);

        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }

    public function testRegistrationSuccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[firstname]'] = 'newuser';
        $form['registration_form[lastname]'] = 'test';
        $form['registration_form[email]'] = 'newuser@example.com';
        $form['registration_form[plainPassword]'] = 'newsecurepassword';

        $client->submit($form);

        // $this->assertResponseRedirects('/login');
        $this->assertResponseRedirects();
        $location = $client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/login', $location);
    }
}
