<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Web\{
        Template,
        WebContent,
        Page
    };
    use System\Globalization\{
        CultureInfo
    };
    {
        echo '
            <h2>Testing the integrity of <code>Template</code>, <code>Template::Page</code>, <code>Template::Content</code> and <code>Page</code></h2>';
        echo '
            <p>Generating following structure:</p>
            <div class="alert alert-info">
                <b>$template2</b><br />
                <div class="alert alert-info">
                    <b>$template1</b><br />
                    <div class="alert alert-info">
                        <b>$page</b><br />
                        Locale: \'de-CH\'
                    </div>
                </div>
            </div>';
        
        global $page, $template1, $template2;
        $page = new Page();
        $page->Locale = new CultureInfo('de-CH');
        $template1 = new Template($page);
        $template2 = new Template($template1);
        
        echo "
            <h3>Checking values of <code>\$template1</code>...</h3>";
        RunTest('$template1->Locale->ToString()', 'de-CH');
        RunTest('$template1->Locale', $page->Locale);
        RunTest('$template1->Content->Locale', $page->Locale);
        echo "
            <h3>Checking values of <code>\$template2</code>...</h3>";
        RunTest('$template2->Locale->ToString()', 'de-CH');
        RunTest('$template2->Locale', $page->Locale);
        RunTest('$template2->Content->Locale', $template1->Locale);
        echo "
            <h3>Checking values of <code>\$page</code>...</h3>";
        RunTest('$page->Locale->ToString()', 'de-CH');
    }
?>