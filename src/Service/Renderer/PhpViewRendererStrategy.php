<?php

declare(strict_types=1);

namespace TypedView\Service\Renderer;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\ViewEvent;
use TypedView\Entity\ViewEvent as TypedViewEvent;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class PhpViewRendererStrategy extends AbstractListenerAggregate
{
    public function __construct(private PhpViewRenderer $renderer)
    {
        // php8 ctor
    }

    public function getRenderer(): PhpViewRenderer
    {
        return $this->renderer;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    public function selectRenderer(ViewEvent $event): PhpViewRenderer
    {
        return $this->renderer;
    }

    public function injectResponse(ViewEvent $event): void
    {
        if (! $event instanceof TypedViewEvent) {
            return;
        }

        $renderer = $event->getTypedRenderer();
        $response = $event->getResponse();

        if ($renderer !== $this->renderer || $response === null) {
            return;
        }

        $result = $event->getResult();
        $response->setContent($result);
    }
}
