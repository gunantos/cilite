<?php
namespace appkita\cilite\Core;
use \CodeIgniter\View\Exceptions\ViewException;
use \CodeIgniter\View\View as ViewCI;

class View extends ViewCI
{
    /**
     * this path from view in cilite
     * @var string $viewPath_cilite
     */
    protected $viewPath_cilite;

    public function __construct(\Config\View $config, ?string $viewPath = null, ?\CodeIgniter\Autoloader\FileLocator $loader = null, ?bool $debug = null, ?\Psr\Log\LoggerInterface $logger = null)
    {
        parent::__construct($config, $viewPath, $loader, $debug, $logger);
        $this->viewPath_cilite = (dirname(__DIR__)) .DIRECTORY_SEPARATOR. 'Views'.DIRECTORY_SEPARATOR;
    }

    protected function buildmenu_from_map($map, $item = '',  $res=[]) {
        foreach($map as $key => $val) {
            $key = \str_replace('\\', '', $key);
            if (is_array($val)) {
                $item .= '/' . $key;
                $res = $this->buildmenu_from_map($val, $item, $res);
            } else {
                $exts = \explode('.', $val);
                $ext  = array_pop($exts);
                if ($ext == 'php') {
                    $item = \ltrim($item, '/');
                    $hasil = $item .'/' . $val;
                }
                if (!empty($hasil)) {
                    array_push($res, $hasil);
                }
            }
        }
        return $res;
    }

    protected function get_controller_file(string $path, string $name) : string{
       # helper('filesystem');
       # $map = \directory_map($path);
       # $list_file = $this->buildmenu_from_map($map);
       # for ($i = 0; $i < sizeof($list_file); $i++) {

       # }
        return $path.$name;
    }

     public function render(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        $this->renderVars['start'] = microtime(true);

        // Store the results here so even if
        // multiple views are called in a view, it won't
        // clean it unless we mean it to.
        $saveData ??= $this->saveData;
        $fileExt                     = pathinfo($view, PATHINFO_EXTENSION);
        $realPath                    = empty($fileExt) ? $view . '.php' : $view; // allow Views as .html, .tpl, etc (from CI3)
        $this->renderVars['view']    = $realPath;
        $this->renderVars['options'] = $options ?? [];

        // Was it cached?
        if (isset($this->renderVars['options']['cache'])) {
            $cacheName = $this->renderVars['options']['cache_name'] ?? str_replace('.php', '', $this->renderVars['view']);
            $cacheName = str_replace(['\\', '/'], '', $cacheName);

            $this->renderVars['cacheName'] = $cacheName;

            if ($output = cache($this->renderVars['cacheName'])) {
                $this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);

                return $output;
            }
        }

        
        $this->renderVars['file'] = $this->get_controller_file($this->viewPath, $this->renderVars['view']);

        if (! is_file($this->renderVars['file'])) {
           $this->renderVars['file'] =  $this->get_controller_file($this->viewPath_cilite, $this->renderVars['view']);

            if (! is_file($this->renderVars['file'])) {
                $this->renderVars['file'] = $this->loader->locateFile($this->renderVars['view'], 'Views', empty($fileExt) ? 'php' : $fileExt);
            }
        }
        // locateFile will return an empty string if the file cannot be found.
        if (empty($this->renderVars['file'])) {
            throw ViewException::forInvalidFile($this->renderVars['view']);
        }

        // Make our view data available to the view.
        $this->prepareTemplateData($saveData);

        // Save current vars
        $renderVars = $this->renderVars;

        $output = (function (): string {
            extract($this->tempData);
            ob_start();
            include $this->renderVars['file'];

            return ob_get_clean() ?: '';
        })();

        // Get back current vars
        $this->renderVars = $renderVars;

        // When using layouts, the data has already been stored
        // in $this->sections, and no other valid output
        // is allowed in $output so we'll overwrite it.
        if ($this->layout !== null && $this->sectionStack === []) {
            $layoutView   = $this->layout;
            $this->layout = null;
            // Save current vars
            $renderVars = $this->renderVars;
            $output     = $this->render($layoutView, $options, $saveData);
            // Get back current vars
            $this->renderVars = $renderVars;
        }

        $output = $this->decorateOutput($output);

        $this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);

        if (($this->debug && (! isset($options['debug']) || $options['debug'] === true))
            && in_array(DebugToolbar::class, service('filters')->getFiltersClass()['after'], true)
        ) {
            $toolbarCollectors = config(Toolbar::class)->collectors;

            if (in_array(Views::class, $toolbarCollectors, true)) {
                // Clean up our path names to make them a little cleaner
                $this->renderVars['file'] = clean_path($this->renderVars['file']);
                $this->renderVars['file'] = ++$this->viewsCount . ' ' . $this->renderVars['file'];

                $output = '<!-- DEBUG-VIEW START ' . $this->renderVars['file'] . ' -->' . PHP_EOL
                    . $output . PHP_EOL
                    . '<!-- DEBUG-VIEW ENDED ' . $this->renderVars['file'] . ' -->' . PHP_EOL;
            }
        }

        // Should we cache?
        if (isset($this->renderVars['options']['cache'])) {
            cache()->save($this->renderVars['cacheName'], $output, (int) $this->renderVars['options']['cache']);
        }

        $this->tempData = null;

        return $output;
    }
}