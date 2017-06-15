<?php
    use System\Web\{
        StyleSheet,
        StyleDefinition,
        ScriptDefinition
    };
    {
        $testScript = ScriptDefinition::FromCode('
            $(document).ready(function()
            {
                {
                    let text;
                    
                    if ($("#bootstrapTheme-test").css("color") != $("html").css("color"))
                    {
                        text = "Test passed!";
                    }
                    else
                    {
                        text = "Test not passed";
                    }

                    $("#bootstrapTheme-result").html("<b>" + text + "</b>");
                }
                {
                    let text;

                    if ($("#styleTest").css("color") == "rgb(135, 206, 235)")
                    {
                        text = "Test passed!";
                    }
                    else
                    {
                        text = "Test not passed";
                    }

                    $("#styleTest-result").html("<b>" + text + "</b>");
                }
            });');
        $bootstrap = new StyleSheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        $bootstrapTheme = StyleDefinition::FromFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css');
        $style = StyleDefinition::FromCode('
            #styleTest
            {
                color: skyblue !important;
            }');
        echo $testScript->Print();
        echo $bootstrap->Print();
        echo $bootstrapTheme->Print();
        echo $style->Print();
        echo '
            <h2>Including Bootstrap using <code>StyleSheet</code></h2>
            <p>
                <code id="bootstrapTheme-test">Testing font-color of this paragraph...</code>
            </p>
            <p id="bootstrapTheme-result"><b>Test not passed</b></p>

            <h2>Including inline-css using <code>InlineStyle</code></h2>
            <p id="styleTest">Testing font-color of this paragraph...</p>
            <p id="styleTest-result"><b>Test not passed</b></p>';
    }
?>