<?php

declare(strict_types=1);

namespace TypedView\Service;

use Exception;
use JetBrains\PhpStorm\Pure;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Stdlib\RequestInterface;
use Laminas\Stdlib\ResponseInterface;
use RecursiveIteratorIterator;
use RuntimeException;
use TypedView\Entity\ViewEvent;
use TypedView\Entity\ViewModel;
use TypedView\Service\Renderer\ViewRenderer;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class View implements EventManagerAwareInterface
{
    protected RequestInterface $request;
    protected ResponseInterface $response;
    private EventManagerInterface $events;

    public function setRequest(RequestInterface $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setResponse(ResponseInterface $response): self
    {
        $this->response = $response;

        return $this;
    }

    #[Pure]
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    #[Pure]
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function setEventManager(EventManagerInterface $events): self
    {
        $events->setIdentifiers([self::class, static::class]);
        $this->events = $events;

        return $this;
    }

    public function getEventManager(): EventManagerInterface
    {
        if (! $this->events instanceof EventManagerInterface) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }

    /** @throws Exception */
    public function render(ViewModel $root): void
    {
        $event = $this->getEvent();
        $events = $this->getEventManager();
        $models = new RecursiveIteratorIterator($root->getIterator(), RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($models as $model) {
            $event->setTypedModel($model);
            $event->setName(ViewEvent::EVENT_RENDERER);
            $results = $events->triggerEventUntil(static fn ($result) => $result instanceof ViewRenderer, $event);
            $renderer = $results->last();

            if (! $renderer instanceof ViewRenderer) {
                throw new RuntimeException(sprintf('%s: no renderer selected!', __METHOD__));
            }

            $event->setTypedRenderer($renderer);
            $event->setName(ViewEvent::EVENT_RENDERER_POST);
            $events->triggerEvent($event);

            // If EVENT_RENDERER or EVENT_RENDERER_POST changed the model, make sure we use this new model.
            $model = $event->getTypedModel();
            $rendered = $renderer->render($model);

            if ($callback = $model->getCaptureCallback()) {
                $callback($rendered);
            }
        }

        $event->setResult($rendered ?? '');
        $event->setName(ViewEvent::EVENT_RESPONSE);
        $events->triggerEvent($event);
    }

    protected function getEvent(): ViewEvent
    {
        $event = new ViewEvent();
        $event->setTarget($this);
        $event->setRequest($this->request);
        $event->setResponse($this->response);

        return $event;
    }
}
