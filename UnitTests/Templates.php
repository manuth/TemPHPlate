<?php
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
                Locale: \'en-US\'
                <div class="alert alert-info">
                    <b>$template1</b><br />
                    Locale: \'en-GB\'
                    <div class="alert alert-info">
                        <b>$page</b><br />
                        Locale: \'de-CH\'
                    </div>
                </div>
            </div>';
        $page = new Page();
        $page->Locale = new CultureInfo('de-CH');
        $template1 = new Template($page);
        $template1->Locale = new CultureInfo('en-GB');
        $template2 = new Template($template1);
        $template2->Locale = new CultureInfo('en-US');
        
        echo "
            <h3>Checking values of <code>\$template1</code>...</h3>";
        echo "
            <p>
                Checking <code>\$template1->Locale</code>: {$template1->Locale} (excepting 'en-GB')<br />
                <b>".($template1->Locale == 'en-GB' ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <p>
                Checking <code>\$template1->Page->Locale</code>: {$template1->Page->Locale} (excepting '{$page->Locale}')<br />
                <b>".($template1->Page->Locale == $page->Locale ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <p>
                Checking <code>\$template1->Content->Locale</code>: {$template1->Content->Locale} (excepting '{$page->Locale}')<br />
                <b>".($template1->Content->Locale == $page->Locale ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <h3>Checking values of <code>\$template2</code>...</h3>";
        echo "
            <p>
                Checking <code>\$template2->Locale</code>: {$template2->Locale} (excepting 'en-US')<br />
                <b>".($template2->Locale == 'en-US' ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <p>
                Checking <code>\$template2->Page->Locale</code>: {$template2->Page->Locale} (excepting '{$page->Locale}')<br />
                <b>".($template2->Page->Locale == $page->Locale ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <p>
                Checking <code>\$template2->Content->Locale</code>: {$template2->Content->Locale} (excepting '{$template1->Locale}')<br />
                <b>".($template2->Content->Locale == $template1->Locale ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
        echo "
            <h3>Checking values of <code>\$page</code>...</h3>";
        echo "
            <p>
                Checking <code>\$page->Locale</code>: {$page->Locale} (excepting 'de-CH')<br />
                <b>".($page->Locale == 'de-CH' ? 'Test passed!' : 'Test not passed')."</b>
            </p>";
    }
?>