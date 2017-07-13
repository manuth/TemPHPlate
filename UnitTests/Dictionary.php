<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Collections\{
        ArrayList,
        Dictionary
    };
    {
        echo '
            <h2>Testing <code>Dictionary</code>-Functionalities</h2>';
        RunTest('$dictionary = new System\Collections\Dictionary()');
        RunTest('$dictionary->Count', 0);
        RunTest('$dictionary->Add("Key", "Value")');
        RunTest('$dictionary = new System\Collections\Dictionary($dictionary)');
        RunTest('$dictionary->Count', 1);
        RunTest('
            $dictionary = new System\Collections\Dictionary(
                $dictionary,
                new System\Collections\EqualityComparer(
                    function ($x, $y)
                    {
                        return strlen($x) === strlen($y);
                    }))');
        RunTest('
            (function () use ($dictionary)
            {
                try
                {
                    $dictionary->Add("Key", "Value2");
                    return true;
                }
                catch (Exception $exception)
                {
                    return false;
                }
            })()', false);
        RunTest('$dictionary->Comparer instanceof System\Collections\EqualityComparer', true);
        RunTest('$dictionary->Count', 1);
        RunTest('$dictionary->Keys->Count()', 1);
        RunTest('method_exists($dictionary->Keys, "Add")', false);
        RunTest('$dictionary->Keys->ToArray()[0]', 'Key');
        RunTest('$dictionary->Values->ToArray()[0]', 'Value');
        RunTest('$dictionary[$dictionary->Keys->ToArray()[0]]', 'Value');
        RunTest('isset($dictionary["Key1337"])', false);
        RunTest('isset($dictionary["Key"])', true);
        RunTest('$dictionary["Key"]', 'Value');
        RunTest('$dictionary["Key"] = "NewValue"');
        RunTest('$dictionary["Key"]', 'NewValue');
        RunTest('unset($dictionary["Key"])');
        RunTest('$dictionary->ContainsKey("Key")', false);
        RunTest('$dictionary->Add("Key2", "Value2")');
        RunTest('$dictionary["Key2"]', 'Value2');
        RunTest('$dictionary->Clear()');
        RunTest('$dictionary->Count', 0);
        RunTest('$dictionary->Add("Key", "Value")');
        RunTest('$entry = $dictionary->First()');
        RunTest('$dictionary->Contains($entry)', true);
        RunTest('$dictionary->Contains(new System\Collections\KeyValuePair("Key", "Value"))', false);
        RunTest('$dictionary->ContainsKey("Key")', true);
        RunTest('$dictionary->ContainsValue("Value")', true);
        RunTest('$dictionary->Remove("Key")');
        RunTest('$dictionary->ContainsValue("Value")', false);
        RunTest('$dictionary->Add("Test", "TestValue")');
        RunTest('$dictionary->TryGetValue("Test", $value)', true);
        RunTest('$value', 'TestValue');
    }
?>