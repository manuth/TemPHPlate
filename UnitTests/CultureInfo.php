<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Globalization\CultureInfo;
    {
        echo '
            <h2>Trying to change the current locale</h2>';

        global $germanCulture, $englishCulture;
        $germanCulture = new CultureInfo('de-DE');
        $englishCulture = new CultureInfo('en-US');

        echo "
            <h3>Changing the current locale to \"{$englishCulture->Name}\"</h3>";
        
        RunTest('System\Globalization\CultureInfo::SetCurrentCulture($englishCulture)');

        RunTest('setlocale(LC_ALL, 0)', $englishCulture->Name, preg_replace('/(\w*)-(\w*)/', '$1_$2.UTF8', $englishCulture->Name));

        echo "
            <h3>Changing the current locale to \"{$germanCulture->Name}\"</h3>";

        RunTest('System\Globalization\CultureInfo::SetCurrentCulture($germanCulture)');

        $locale = setlocale(LC_ALL, 0);
        
        RunTest('setlocale(LC_ALL, 0)', $germanCulture->Name, preg_replace('/(\w*)-(\w*)/', '$1_$2.UTF8', $germanCulture->Name));
    }
?>