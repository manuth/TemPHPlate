<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Globalization\CultureInfo;
    {
        echo '
            <h2>Trying to change the current locale</h2>';
        $germanCulture = new CultureInfo('de-CH');
        $englishCulture = new CultureInfo('en-US');

        echo "
            <h3>Changing the current locale to \"{$englishCulture->Name}\"</h3>";
        
        RunTest('System\Globalization\CultureInfo::SetCurrentCulture($englishCulture)');

        RunTest('setlocale(LC_ALL, 0)', $englishCulture->Name);

        echo "
            <h3>Changing the current locale to \"{$germanCulture->Name}\"</h3>";

        RunTest('System\Globalization\CultureInfo::SetCurrentCulture($germanCulture)');

        $locale = setlocale(LC_ALL, 0);
        
        RunTest('setlocale(LC_ALL, 0)', $germanCulture->Name);
    }
?>