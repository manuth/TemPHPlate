<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    global $php, $markdown, $html;

    echo '
        <h2>Testing <code>Enum</code>-features</h2>';
    echo 'Testing auto-generated enum-values.<br />';

    RunTest('$php = System\Web\DocumentType::$PHP');
    RunTest('$markdown = System\Web\DocumentType::$MarkDown');
    RunTest('$html = System\Web\DocumentType::$HTML');
    RunTest('$php->Value', 0);
    RunTest('$markdown->Value', 1);
    RunTest('$html->Value', 2);
    RunTest('$php->HasFlag($php)', true);

    echo 'Testing string-representations.<br />';

    RunTest('$php->ToString()', 'PHP');
    RunTest('$php->SetFlag($markdown)');
    RunTest('strpos($php, "PHP") !== false && strpos($php, "MarkDown") !== false', true);
?>