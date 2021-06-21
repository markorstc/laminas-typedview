<?php

declare(strict_types=1);

namespace TypedView;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class Module implements ConfigProviderInterface
{
    /** @return array<string, mixed> */
    public function getConfig(): array
    {
        return require __DIR__ . '/config/module.config.php';
    }
}
