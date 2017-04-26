<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyNotes\JsonRequestBundle\DependencyInjection\JsonRequestExtension;

/**
 * Class SymfonyNotesJsonRequestBundle
 */
class SymfonyNotesJsonRequestBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new JsonRequestExtension();
    }
}
