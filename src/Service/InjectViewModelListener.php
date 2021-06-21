<?php

declare(strict_types=1);

namespace TypedView\Service;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use LogicException;
use TypedView\Controller\LayoutModelAware;
use TypedView\Entity\ViewModel;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class InjectViewModelListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectViewModel'], -100);
    }

    public function injectViewModel(MvcEvent $e): void
    {
        $result = $e->getResult();

        if (! $result instanceof ViewModel) {
            return;
        }

        if ($result->getCaptureCallback() === null) {
            $e->setParam(ViewModel::MVC_EVENT_PARAM, $result);

            return;
        }

        $root = $e->getParam(ViewModel::MVC_EVENT_PARAM);

        if (! $root instanceof ViewModel) {
            throw new LogicException(sprintf(
                'Missing layout model. Controller must implement %s.',
                LayoutModelAware::class,
            ));
        }

        $root->addChild($result);
    }
}
