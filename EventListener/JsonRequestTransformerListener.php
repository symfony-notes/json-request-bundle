<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestDecodeException;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestExceptionInterface;

/**
 * Class JsonRequestTransformerListener
 */
class JsonRequestTransformerListener implements JsonRequestTransformerListenerInterface
{
    /**
     * @var int
     */
    private $decodeDepth;

    /**
     * @var bool
     */
    private $throwExceptionOnError;

    /**
     * @param int  $decodeDepth
     * @param bool $throwExceptionOnError
     */
    public function __construct(int $decodeDepth, bool $throwExceptionOnError)
    {
        $this->decodeDepth = $decodeDepth;
        $this->throwExceptionOnError = $throwExceptionOnError;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ('json' !== $event->getRequest()->getContentType() && !$event->getRequest()->getContent()) {
            return;
        }

        try {
            $event->getRequest()->request->replace(
                $this->decode($event->getRequest())
            );
        } catch (JsonRequestExceptionInterface $e) {
            if ($this->throwExceptionOnError) {
                throw $e;
            }

            $event->setResponse(Response::create($e->getMessage(), 400));
        }
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    private function decode(Request $request)
    {
        $decoded = json_decode($request->getContent(), true, $this->decodeDepth);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $decoded;

            case JSON_ERROR_DEPTH:
                throw new JsonRequestDecodeException('Could not decode JSON, maximum stack depth exceeded.');

            case JSON_ERROR_STATE_MISMATCH:
                throw new JsonRequestDecodeException('Could not decode JSON, underflow or the nodes mismatch.');

            case JSON_ERROR_CTRL_CHAR:
                throw new JsonRequestDecodeException('Could not decode JSON, unexpected control character found.');

            case JSON_ERROR_SYNTAX:
                throw new JsonRequestDecodeException('Could not decode JSON, syntax error - malformed JSON.');

            case JSON_ERROR_UTF8:
                throw new JsonRequestDecodeException('Could not decode JSON, malformed UTF-8 characters (incorrectly encoded?)');

            default:
                throw new JsonRequestDecodeException('Could not decode JSON.');
        }
    }
}
