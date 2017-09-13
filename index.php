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
        $mainTime = microtime(true);
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

        include 'UnitTests/index.php';
        var_dump(microtime(true) - $mainTime);
    }
?>