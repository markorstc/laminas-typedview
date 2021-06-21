<?php

declare(strict_types=1);

namespace TypedView\Entity;

use Laminas\Paginator\Paginator;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Helper\Cycle;
use Laminas\View\Helper\DeclareVars;
use Laminas\View\Helper\Doctype;
use Laminas\View\Helper\Escaper\AbstractHelper as EscaperAbstractHelper;
use Laminas\View\Helper\FlashMessenger;
use Laminas\View\Helper\Gravatar;
use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadMeta;
use Laminas\View\Helper\HeadScript;
use Laminas\View\Helper\HeadStyle;
use Laminas\View\Helper\HeadTitle;
use Laminas\View\Helper\InlineScript;
use Laminas\View\Helper\Layout;
use Laminas\View\Helper\Navigation;
use Laminas\View\Helper\Navigation\Breadcrumbs;
use Laminas\View\Helper\Navigation\Links;
use Laminas\View\Helper\Navigation\Menu;
use Laminas\View\Helper\Navigation\Sitemap;
use Laminas\View\Helper\Partial;
use Laminas\View\Helper\Placeholder\Container\AbstractContainer;
use Laminas\View\Helper\ViewModel as LaminasViewModel;
use TypedView\Helper\ViewHelper;
use TypedView\Helper\ViewHelperAware;

use function call_user_func_array;
use function is_callable;

/**
 * Convenience methods for build in helpers {@see LaminasBridgeModel::__call()}:
 *
 * @method string asset($asset)
 * @method string|null basePath($file = null)
 * @method Cycle cycle(array $data = [], $name = Cycle::DEFAULT_NAME)
 * @method DeclareVars declareVars()
 * @method Doctype doctype($doctype = null)
 * @method mixed escapeCss($value, $recurse = EscaperAbstractHelper::RECURSE_NONE)
 * @method mixed escapeHtml($value, $recurse = EscaperAbstractHelper::RECURSE_NONE)
 * @method mixed escapeHtmlAttr($value, $recurse = EscaperAbstractHelper::RECURSE_NONE)
 * @method mixed escapeJs($value, $recurse = EscaperAbstractHelper::RECURSE_NONE)
 * @method mixed escapeUrl($value, $recurse = EscaperAbstractHelper::RECURSE_NONE)
 * @method FlashMessenger flashMessenger($namespace = null)
 * @method Gravatar gravatar($email = "", $options = [], $attribs = [])
 * @method HeadLink headLink(array $attributes = null, $placement = AbstractContainer::APPEND)
 * @method HeadMeta headMeta($content = null, $keyValue = null, $keyType = 'name', $modifiers = [], $placement = AbstractContainer::APPEND)
 * @method HeadScript headScript($mode = HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = [], $type = 'text/javascript')
 * @method HeadStyle headStyle($content = null, $placement = 'APPEND', $attributes = [])
 * @method HeadTitle headTitle($title = null, $setType = null)
 * @method string htmlFlash($data, array $attribs = [], array $params = [], $content = null)
 * @method string htmlList(array $items, $ordered = false, $attribs = false, $escape = true)
 * @method string htmlObject($data = null, $type = null, array $attribs = [], array $params = [], $content = null)
 * @method string htmlPage($data, array $attribs = [], array $params = [], $content = null)
 * @method string htmlQuicktime($data, array $attribs = [], array $params = [], $content = null)
 * @method mixed|null identity()
 * @method InlineScript inlineScript($mode = HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = [], $type = 'text/javascript')
 * @method string|void json($data, array $jsonOptions = [])
 * @method Layout layout($template = null)
 * @method Navigation navigation($container = null)
 * @method string paginationControl(Paginator $paginator = null, $scrollingStyle = null, $partial = null, $params = null)
 * @method string|Partial partial($name = null, $values = null)
 * @method string partialLoop($name = null, $values = null)
 * @method AbstractContainer placeholder($name = null)
 * @method string renderChildModel($child)
 * @method void renderToPlaceholder($script, $placeholder)
 * @method string serverUrl($requestUri = null)
 * @method string url($name = null, array $params = [], $options = [], $reuseMatchedParams = false)
 * @method LaminasViewModel viewModel()
 * @method Breadcrumbs breadCrumbs($container = null)
 * @method Links links($container = null)
 * @method Menu menu($container = null)
 * @method Sitemap sitemap($container = null)
 *
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
abstract class LaminasBridgeModel extends ViewModel implements ViewHelperAware
{
    use ViewHelper;

    public function plugin(string $name, ?array $options = null): AbstractHelper
    {
        return $this->getViewHelperManager()->get($name, $options);
    }

    /**
     * Overloading: proxy to helpers
     *
     * Proxies to the attached plugin manager to retrieve, return, and potentially
     * execute helpers.
     *
     * * If the helper does not define __invoke, it will be returned
     * * If the helper does define __invoke, it will be called as a functor
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call(string $method, array $args): mixed
    {
        $plugin = $this->plugin($method);

        if (is_callable($plugin)) {
            return call_user_func_array($plugin, $args);
        }

        return $plugin;
    }
}
