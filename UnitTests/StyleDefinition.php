<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Web\{
        ScriptDefinition,
        StyleCollection,
        StyleDefinition,
        StyleSheet
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
        $styleCollection = new StyleCollection();
        $styleCollection->Add(new StyleSheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'));
        $styleCollection->Add(StyleDefinition::FromFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css'));
        $styleCollection->Add(StyleDefinition::FromCode('
            #styleTest
            {
                color: skyblue !important;
            }'));
        echo $testScript->Print();
        echo $styleCollection->Print();
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