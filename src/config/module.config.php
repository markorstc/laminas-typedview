<?php

declare(strict_types=1);

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */

namespace TypedView;

use Interop\Container\ContainerInterface as Container;
use Laminas\ServiceManager\Factory\InvokableFactory;
use TypedView\Service\DispatchableViewLayoutInitializer;
use TypedView\Service\InjectHelperPluginListener;
use TypedView\Service\InjectViewModelListener;
use TypedView\Service\MvcRenderingStrategy;
use TypedView\Service\Renderer\PhpViewRenderer;
use TypedView\Service\Renderer\PhpViewRendererStrategy;
use TypedView\Service\View;
use TypedView\Service\ViewFactory;

return [
    'service_manager' => [
        'factories' => [
            MvcRenderingStrategy::class
                => static fn (Container $sm) => new MvcRenderingStrategy($sm->get(View::class)),
            PhpViewRendererStrategy::class
                => static fn (Container $sm) => new PhpViewRendererStrategy($sm->get(PhpViewRenderer::class)),
            InjectHelperPluginListener::class
                => static fn (Container $sm) => new InjectHelperPluginListener($sm->get('ViewHelperManager')),
            PhpViewRenderer::class => InvokableFactory::class,
            InjectViewModelListener::class => InvokableFactory::class,
            View::class => ViewFactory::class,
        ],
    ],
    'controllers' => [
        'initializers' => [DispatchableViewLayoutInitializer::class],
    ],
    'view_manager' => [
        'mvc_strategies' => [MvcRenderingStrategy::class],
        'strategies' => [PhpViewRendererStrategy::class],
    ],
    'listeners' => [InjectViewModelListener::class],
];
