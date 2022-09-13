<?php

namespace appkita\cilite\Config;
use \CodeIgniter\Config\BaseService;
use \appkita\cilite\Core\View;
use \appkita\cilite\Core\Parser;
use \Config\Services as AppServices;

class Services extends BaseService
{
     /**
     * The Parser is a simple template parser.
     *
     * @return Parser
     */
    public static function parser(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('parser', $viewPath, $config);
        }

        $viewPath = $viewPath ?: config('Paths')->viewDirectory;
        $config ??= config('View');

        return new Parser($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
    }

    /**
     * The Renderer class is the class that actually displays a file to the user.
     * The default View class within CodeIgniter is intentionally simple, but this
     * service could easily be replaced by a template engine if the user needed to.
     *
     * @return View
     */
    public static function renderer(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('renderer', $viewPath, $config);
        }

        $viewPath = $viewPath ?: config('Paths')->viewDirectory;
        $config ??= config('View');

        return new View($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
    }
}
