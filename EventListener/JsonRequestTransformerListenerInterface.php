<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestExceptionInterface;

/**
 * Interface JsonRequestTransformerListenerInterface
 */
interface JsonRequestTransformerListenerInterface
{
    /**
     * @param GetResponseEvent $event
     *
     * @return void
     *
     * @throws JsonRequestExceptionInterface
     */
    public function onKernelRequest(GetResponseEvent $event);
}
