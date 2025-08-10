<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

trait DatabaseTestTrait
{
    protected EntityManagerInterface $em;

    protected function setUpDatabase(): void
    {
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }
}
