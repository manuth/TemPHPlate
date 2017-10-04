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
    {
        $page = new Page();
        $page->StyleDefinitions->Add(new StyleSheet('./markdown.css'));
        $page->StyleDefinitions->Add(new StyleSheet('./tomorrow.css'));
        $page->Title = "This is a test.";

        echo $page->Draw();
    }
?>