<?php
namespace appkita\cilite\Libraries;

class MenuLib
{
    protected static function list_from_folder($folder)
    {
        helper('filesystem');
        $map = \directory_map($folder);
        $items = [];
    }

    public static function menu_admin()
    {
        $folder = APPPATH . 'Controllers'.DIRECTORY_SEPARATOR.'Admin'.DIRECTORY_SEPARATOR;
        $folder_cilite = CILITEPATH . 'Controllers'.DIRECTORY_SEPARATOR.'Admin'.DIRECTORY_SEPARATOR;

        $config = \config('Cilite');
        
        $item = [];

        if (\sizeof($config->items_admin) > 0) {
            $list = $config->items_admin;
            foreach($config->items_admin as $key => $val) {
                array_push($items, $key);
            }
        }else {
            $list = MenuLib::list_from_folder('admin');
        }
        return $item;
    }
}