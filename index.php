<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    DEFINE('TemPHPlate', null);
    DEFINE('DefaultNamespace', 'ManuTh\\TemPHPlate');

    foreach (json_decode(file_get_contents(join(DIRECTORY_SEPARATOR, array(__DIR__, 'Properties', 'Config.json')), true)) as $key => $value)
    {
        DEFINE('TemPHPlate'.$key, $value);
    }

    require('autoload.php');
    use System\{
        Environment,
        Exception,
        Globalization\CultureInfo,
        Collections\ArrayList,
        Web\DocumentPage
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

        
        if (array_key_exists('Page', $_GET) && LoadPage(str_replace('/', '\\', $_GET['Page'])) != null)
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
                DefaultNamespace.'\\Pages',
                TemPHPlateNamespace.'\\Pages');

            foreach ($namespaces as $namespace)
            {
                $pageClass = $namespace.'\\'.$pageName;

                if (class_exists($pageClass))
                {
                    return new $pageClass();
                }
            }
            
            $fileExtensions = new ArrayList(
                array(
                    'php',
                    'php3',
                    'php4',
                    'php5',
                    'php.inc',
                    'inc',
                    'markdown',
                    'mkdown',
                    'mkdn',
                    'mkd',
                    'md',
                    'txt'));
            
            $files = $fileExtensions->ConvertAll(
                function ($extension) use ($pageName)
                {
                    return join(DIRECTORY_SEPARATOR, array(__DIR__, 'Pages', str_replace('\\', DIRECTORY_SEPARATOR, $pageName).'.'.$extension));
                });
            
            $file = $files->FirstOrDefault(
                function ($file)
                {
                    return file_exists($file);
                });
            
            if ($file !== null)
            {
                return new DocumentPage($file);
            }
            else
            {
                return null;
            }
        }
    }
?>