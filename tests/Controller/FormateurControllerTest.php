<?php

namespace App\Test\Controller;

use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FormateurRepository $repository;
    private string $path = '/formateur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Formateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formateur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'formateur[nomFormateur]' => 'Testing',
            'formateur[prenomFormateur]' => 'Testing',
            'formateur[Diplome]' => 'Testing',
            'formateur[status]' => 'Testing',
            'formateur[bio]' => 'Testing',
            'formateur[telephone]' => 'Testing',
            'formateur[formations]' => 'Testing',
        ]);

        self::assertResponseRedirects('/formateur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formateur();
        $fixture->setNomFormateur('My Title');
        $fixture->setPrenomFormateur('My Title');
        $fixture->setDiplome('My Title');
        $fixture->setStatus('My Title');
        $fixture->setBio('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setFormations('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formateur();
        $fixture->setNomFormateur('My Title');
        $fixture->setPrenomFormateur('My Title');
        $fixture->setDiplome('My Title');
        $fixture->setStatus('My Title');
        $fixture->setBio('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setFormations('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'formateur[nomFormateur]' => 'Something New',
            'formateur[prenomFormateur]' => 'Something New',
            'formateur[Diplome]' => 'Something New',
            'formateur[status]' => 'Something New',
            'formateur[bio]' => 'Something New',
            'formateur[telephone]' => 'Something New',
            'formateur[formations]' => 'Something New',
        ]);

        self::assertResponseRedirects('/formateur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomFormateur());
        self::assertSame('Something New', $fixture[0]->getPrenomFormateur());
        self::assertSame('Something New', $fixture[0]->getDiplome());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getBio());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getFormations());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Formateur();
        $fixture->setNomFormateur('My Title');
        $fixture->setPrenomFormateur('My Title');
        $fixture->setDiplome('My Title');
        $fixture->setStatus('My Title');
        $fixture->setBio('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setFormations('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/formateur/');
    }
}
