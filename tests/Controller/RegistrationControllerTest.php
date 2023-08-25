<?php
 
namespace App\Tests\Controller;
 
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class RegisterTest extends WebTestCase
{
    private $client;
    private $entityManager;
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }
    public function testRenderRegisterPage()
    {
        $this->client->request('GET', '/register'); // Faire la requête

        $this->assertResponseIsSuccessful(); // Vérifier qu'elle est en succès

        $this->assertSelectorTextContains('h1', 'Register'); // Vérifier que la page contient bien le titre
    }
 
    public function testSuccessfulRegister()
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

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'newuser@example.com']);
        $this->assertNotNull($user);
    }

    public function testInvalidEmailFormat()
    {
        $crawler = $this->client->request('GET', '/register');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[firstname]'] = 'newuser';
        $form['registration_form[lastname]'] = 'test';
        $form['registration_form[email]'] = 'invalidemail@mail';
        $form['registration_form[plainPassword]'] = 'newsecurepassword';

        $crawler = $this->client->submit($form);
        $this->assertResponseIsSuccessful();

        // $errorElement = $crawler->filter('.form-error-message:contains("is not a valid email address.")');
        // $this->assertCount(1, $errorElement);
    }
    
 
    protected function tearDown():void{
        parent::tearDown();

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'newuser@example.com']);
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        $this->client = null;
        $this->entityManager = null;
    }
}