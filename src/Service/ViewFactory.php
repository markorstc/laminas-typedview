<?php

declare(strict_types=1);

namespace TypedView\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\View as LaminasView;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class ViewFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): View
    {
        $events = $container->get(LaminasView::class)->getEventManager();
        $container->get(InjectHelperPluginListener::class)->attach($events);

        return (new View())->setEventManager($events);
    }
}
