<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Web\{
        ScriptDefinition
    };
    {
        $jQuery = ScriptDefinition::FromFile('https://code.jquery.com/jquery-3.2.1.js');
        $bootstrapScript = ScriptDefinition::FromFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        $testScript = ScriptDefinition::FromCode('
            $(document).ready(function()
            {
                let testNode = document.getElementById("jQuery-test");
                if ($ != undefined)
                {
                    testNode.innerHTML = "<b>Test passed!</b>";
                }
                else
                {
                    testNode.innerHTML = "<b>Test not passed</b>";
                }
                $("#javaScript-test").html("<b>Test passed!</b>");
            });');
        echo $jQuery->Draw();
        echo $bootstrapScript->Draw();
        echo $testScript->Draw();
        echo '
            <h2>Including scripts (jQuery, Bootstrap) using <code>ScriptFile</code></h2>
            <p id="jQuery-test"><b>Test not passed</b></p>
            <h2>Running JavaScript using <code>InlineScript</code></h2>
            <p id="javaScript-test"><b>Test not passed</b></p>';
    }
?>