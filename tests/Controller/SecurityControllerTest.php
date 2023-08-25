<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    private $client;
 
    protected function setUp():void
    {
        parent::setUp();

        $this->client = static::createClient(); //Créer le client
    }

    public function testLoginPageIsRender()
    {
        $this->client->request('GET', '/login'); // Faire la requête

        $this->assertResponseIsSuccessful(); // Vérifier qu'elle est en succès

        $this->assertSelectorTextContains('h1', 'Please sign in'); // Vérifier que la page contient bien le titre
    }

    public function testLoginSuccess()
    {
        $crawler = $this->client->request('GET', '/login'); // Faire la requête

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'john@example.com';
        $form['_password'] = 'securepassword';

        $this->client->submit($form); // Soumettre le formulaire

        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/', $location); // vérifier qu'on est bien redirigé vers la page d'accueil

        $crawler = $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', "Page d'accueil"); // vérifier que la page d'accueil contient bien les bons textes
    }

    public function testLoginFailure()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'john@example.com';
        $form['_password'] = 'wrongpassword';

        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }

    public function testRegistrationSuccess()
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[firstname]'] = 'newuser';
        $form['registration_form[lastname]'] = 'test';
        $form['registration_form[email]'] = 'newuser@example.com';
        $form['registration_form[plainPassword]'] = 'newsecurepassword';

        $this->client->submit($form);

        // $this->assertResponseRedirects('/login');
        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/login', $location);
    }
}
