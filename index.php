<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    DEFINE('TemPHPlate', null);

    foreach (json_decode(file_get_contents(join(DIRECTORY_SEPARATOR, array(__DIR__, 'Properties', 'Config.json')), true)) as $key => $value)
    {
        DEFINE('TemPHPlate'.$key, $value);
    }

    require('autoload.php');
    use System\{
        Exception,
        Globalization\CultureInfo
    };
    use ManuTh\TemPHPlate\Properties\Settings;
    {
        // $mainTime = microtime(true);
        for ($i = 0; $i < count(Settings::$Locales); $i++)
        {
            $cultureInfo = new CultureInfo(Settings::$Locales[$i]);

            try
            {
                CultureInfo::SetCurrentCulture($cultureInfo);
                break;
            }
            catch (Exception $e)
            { }
        }

        
        if (array_key_exists('Page', $_GET) && LoadPage($_GET['Page']) != null)
        {
            $page = LoadPage(str_replace('/', '\\', $_GET['Page']));
        }
        else
        {
            $page = LoadPage(str_replace('/', '\\', Settings::$FallbackPage));
        }

        echo $page->Draw();
        // include 'UnitTests/index.php';
        // var_dump(microtime(true) - $mainTime);
        
        /**
         * Loads a page.
         *
         * @param string $pageName
         * The name of the page to load.
         * 
         * @return void
         * Returns the loaded page.
         */
        function LoadPage(string $pageName)
        {
            $namespaces = array(
                'ManuTh\\TemPHPlate\\Pages',
                TemPHPlateNamespace.'\\Pages');

            foreach ($namespaces as $namespace)
            {
                $pageClass = $namespace.'\\'.$pageName;

                if (class_exists($pageClass))
                {
                    return new $pageClass();
                }
            }
            
            if (file_exists(($markdownFile = join(DIRECTORY_SEPARATOR, array(__DIR__, str_replace('\\', DIRECTORY_SEPARATOR, $pageName).'.md')))))
            {
                return new MarkdownPage($markdownFile);
            }
            else
            {
                return null;
            }
        }
    }
?>