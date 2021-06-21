<?php

declare(strict_types=1);

namespace TypedView\Service\Renderer;

use TypedView\Entity\ViewModel;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
interface ViewRenderer
{
    public function render(ViewModel $view): string;
}
