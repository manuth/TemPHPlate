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
    {
        phpinfo();
    }
?>