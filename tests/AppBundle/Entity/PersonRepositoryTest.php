<?php

use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchAll()
    {
        $persons = $this->em
            ->getRepository('AppBundle:Person')
            ->findAllOrderedByName();

        $this->assertGreaterThan(0, $persons);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
    }
}