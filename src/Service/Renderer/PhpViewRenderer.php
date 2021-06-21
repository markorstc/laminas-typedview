<?php

declare(strict_types=1);

namespace TypedView\Service\Renderer;

use Throwable;
use TypedView\Entity\ViewModel;

use function ob_end_clean;
use function ob_get_clean;
use function ob_start;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class PhpViewRenderer implements ViewRenderer
{
    public function render(ViewModel $view): string
    {
        return (static function (ViewModel $view): string {
            try {
                ob_start();

                require $view->getTemplate();

                return ob_get_clean();
            } catch (Throwable $t) {
                ob_end_clean();

                throw $t;
            }
        })($view);
    }
}
