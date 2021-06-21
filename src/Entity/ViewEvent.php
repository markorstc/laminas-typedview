<?php

declare(strict_types=1);

namespace TypedView\Entity;

use JetBrains\PhpStorm\Pure;
use Laminas\View\ViewEvent as LaminasViewEvent;
use TypedView\Service\Renderer\ViewRenderer;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class ViewEvent extends LaminasViewEvent
{
    protected ViewModel $typedModel;
    protected ViewRenderer $typedRenderer;

    #[Pure]
    public function getTypedModel(): ViewModel
    {
        return $this->typedModel;
    }

    public function setTypedModel(ViewModel $model): self
    {
        $this->typedModel = $model;

        return $this;
    }

    #[Pure]
    public function getTypedRenderer(): ViewRenderer
    {
        return $this->typedRenderer;
    }

    public function setTypedRenderer(ViewRenderer $typedRenderer): self
    {
        $this->typedRenderer = $typedRenderer;

        return $this;
    }
}
