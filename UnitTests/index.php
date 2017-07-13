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

            function RunTest($expression, $exceptedValue = null, $strict = true)
            {
                if (func_num_args() == 1)
                {
                    TryRun($expression);
                }
                else
                {
                    $value = Run('return '.$expression);
                    
                    if (!is_bool($exceptedValue) && !is_null($exceptedValue))
                    {
                        $displayExceptedValue = (string)$exceptedValue;
                    }
                    else
                    {
                        $displayExceptedValue = json_encode($exceptedValue);
                    }

                    if (!is_bool($value) && !is_null($value))
                    {
                        $displayValue = (string)$value;
                    }
                    else
                    {
                        $displayValue = json_encode($value);
                    }

                    echo "
                        <p>
                            Checking <code>{$expression}</code>: {$displayValue} (excepting '{$displayExceptedValue}')<br />
                            <b>".(($strict ? $value === $exceptedValue : $value == $exceptedValue) ? 'Test passed!' : 'Test not passed.')."</b>
                        </p>";
                }
            }

            include 'JavaScript.php';
            include 'StyleDefinition.php';
            include 'Templates.php';
            include 'CultureInfo.php';
            include 'ArrayList.php';
            include 'Dictionary.php';
            include 'Pages.php';
        }
    ?>
</div>