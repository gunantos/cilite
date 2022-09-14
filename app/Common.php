<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */
if (! defined('CILITEPATH')) {
    /**
     * @var Paths $paths
     */
    define('CILITEPATH', realpath(APPPATH.'ThirdParty'.DIRECTORY_SEPARATOR.'appkita'.DIRECTORY_SEPARATOR.'cilite') . DIRECTORY_SEPARATOR);
}

if (! function_exists('config')) {
    /**
     * More simple way of getting config instances from Factories
     *
     * @return mixed
     */
    function config(string $name, bool $getShared = true)
    {
        return \CodeIgniter\Config\Factories::config($name, ['getShared' => $getShared]);
    }
}