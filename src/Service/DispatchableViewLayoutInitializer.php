<?php

declare(strict_types=1);

namespace TypedView\Service;

use Interop\Container\ContainerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\ServiceManager\Initializer\InitializerInterface;
use Laminas\Stdlib\DispatchableInterface;
use TypedView\Controller\LayoutModelAware;
use TypedView\Entity\ViewModel;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class DispatchableViewLayoutInitializer implements InitializerInterface
{
    /**
     * @param ContainerInterface $container
     * @param DispatchableInterface $instance
     */
    public function __invoke(ContainerInterface $container, $instance): void
    {
        if (! $instance instanceof LayoutModelAware && ! method_exists($instance, 'getLayoutModel')) {
            return;
        }

        $instance->getEventManager()->attach(
            MvcEvent::EVENT_DISPATCH,
            static fn (MvcEvent $evt) => $evt->setParam(ViewModel::MVC_EVENT_PARAM, $instance->getLayoutModel()),
        );
    }
}
