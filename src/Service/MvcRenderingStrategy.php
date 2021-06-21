<?php

declare(strict_types=1);

namespace TypedView\Service;

use Application\Service\Application;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ResponseInterface as Response;
use Throwable;
use TypedView\Entity\ViewModel;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class MvcRenderingStrategy extends AbstractListenerAggregate
{
    public function __construct(private View $view)
    {
        // php8 ctor
    }

    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, [$this, 'render'], $priority);
    }

    /** @throws Throwable */
    public function render(MvcEvent $event): Response
    {
        $result = $event->getResult();

        if ($result instanceof Response) {
            return $result;
        }

        $response = $event->getResponse();
        $model = $event->getParam(ViewModel::MVC_EVENT_PARAM);

        if (! $model instanceof ViewModel) {
            return $response;
        }

        $request = $event->getRequest();
        $view = $this->view->setRequest($request)->setResponse($response);

        try {
            $view->render($model);
            $event->stopPropagation(true);
        } catch (Throwable $t) {
            $this->triggerErrorEvent($event, $t);
        }

        return $response;
    }

    /** @throws Throwable */
    private function triggerErrorEvent(MvcEvent $event, Throwable $error): void
    {
        $app = $event->getApplication();
        $events = $app->getEventManager();

        $event->setName(MvcEvent::EVENT_RENDER_ERROR);
        $event->setError(Application::ERROR_EXCEPTION);
        $event->setParam('exception', $error);

        $events->triggerEvent($event);
    }
}
