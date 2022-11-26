<?php

namespace App\Test\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FormationRepository $repository;
    private string $path = '/formation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Formation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formation index');

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
            'formation[nomFormation]' => 'Testing',
            'formation[prixFormation]' => 'Testing',
            'formation[dateDebut]' => 'Testing',
            'formation[dateFin]' => 'Testing',
            'formation[formateurs]' => 'Testing',
        ]);

        self::assertResponseRedirects('/formation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formation();
        $fixture->setNomFormation('My Title');
        $fixture->setPrixFormation('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setFormateurs('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formation();
        $fixture->setNomFormation('My Title');
        $fixture->setPrixFormation('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setFormateurs('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'formation[nomFormation]' => 'Something New',
            'formation[prixFormation]' => 'Something New',
            'formation[dateDebut]' => 'Something New',
            'formation[dateFin]' => 'Something New',
            'formation[formateurs]' => 'Something New',
        ]);

        self::assertResponseRedirects('/formation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomFormation());
        self::assertSame('Something New', $fixture[0]->getPrixFormation());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getFormateurs());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Formation();
        $fixture->setNomFormation('My Title');
        $fixture->setPrixFormation('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setFormateurs('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/formation/');
    }
}
