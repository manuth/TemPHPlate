<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Web\{
        Template,
        WebContent,
        Page,
        StyleSheet
    };
    use ManuTh\TemPHPlate\Properties\Settings;
    {
        echo '
            <h2>Testing the <code>Page</code>-class</h2>';

        global $page, $title, $head;

        echo 'Creating a new page <code>$page</code>...<br />';

        $page = new Page();
        $title = 'This is a test';

        RunTest('$page->StyleDefinitions->Add(new System\Web\StyleSheet("./markdown.css"))');
        RunTest('$page->StyleDefinitions->Add(new System\Web\StyleSheet("./tomorrow.css"))');
        RunTest('$page->Title = "'.$title.'"');
        RunTest('strpos($page->Draw(), "<!DOCTYPE html>") !== false', true);
        RunTest('$head = preg_replace("/[\\s\\S]*(<head>[\\s\\S]*<\/head>)[\\s\\S]*/m", "$1", $page->Draw())');
        RunTest('strpos($head, "<title>'.$title.'</title>") !== false', true);
        RunTest('$page->Locale->Name == System\Globalization\CultureInfo::GetCurrentCulture()->Name', true);
        RunTest('strpos($head, "<link href=\\"./markdown.css\\" rel=\\"stylesheet\\" />") !== false', true);
    }
?>