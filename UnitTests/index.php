<div class="container">
    <?php
        /**
         * @author Manuel Thalmann <m@nuth.ch>
         * @license Apache-2.0
         */
        use System\Collections\{
            ArrayList,
            EqualityComparer
        };
        {
            $z = 2;
            function Run($expression)
            {
                $code = "<?php {$expression} ?>";
                $tokens = new ArrayList(token_get_all($code));

                foreach ($tokens->Where(function ($token)
                {
                    return $token[0] == 320;
                }) as $token)
                {
                    $varName = substr($token[1], 1);

                    global $$varName;
                }

                return eval("{$expression};");
            }

            function TryRun($expression)
            {
                echo "
                    <p>
                        Calling <code>{$expression}</code>... <b>";
                try
                {
                    Run($expression);
                    echo "Success!";
                }
                catch (Exception $exception)
                {
                    echo "Failed!";
                }

                echo "</b>
                    </p>";
            }

            function RunTest($expression, ...$expectedValues)
            {
                if (count($expectedValues) == 0)
                {
                    TryRun($expression);
                }
                else
                {
                    $expectedDisplayValues = array();
                    $value = Run('return '.$expression);
                    
                    for ($i = 0; $i < count($expectedValues); $i++)
                    {
                        if (!is_bool($expectedValues[$i]) && !is_null($expectedValues[$i]))
                        {
                            $expectedDisplayValues[$i] = (string)$expectedValues[$i];
                        }
                        else
                        {
                            $expectedDisplayValues[$i] = json_encode($expectedValues[$i]);
                        }
                    }

                    if (!is_bool($value) && !is_null($value))
                    {
                        $displayValue = (string)$value;
                    }
                    else
                    {
                        $displayValue = json_encode($value);
                    }

                    $passed = function($value) use ($expectedValues)
                    {
                        foreach ($expectedValues as $expectedValue)
                        {
                            if ($value === $expectedValue)
                            {
                                return true;
                            }
                        }

                        return false;
                    };

                    echo "
                        <p>
                            Checking <code>{$expression}</code>: {$displayValue} (excepting '".join("' or '", $expectedDisplayValues)."')<br />
                            <b>".($passed($value) ? 'Test passed!' : 'Test not passed.')."</b>
                        </p>";
                }
            }

            $time = microtime(true);
            include 'JavaScript.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'StyleDefinition.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'Templates.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'CultureInfo.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'ArrayList.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'Dictionary.php';
            var_dump(microtime(true) - $time);
            $time = microtime(true);
            include 'Pages.php';
            var_dump(microtime(true) - $time);
        }
    ?>
</div>