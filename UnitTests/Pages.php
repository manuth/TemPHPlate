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
        $page->StyleDefinitions->Add(new StyleSheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'));
        echo $page->Draw();
    }
?>