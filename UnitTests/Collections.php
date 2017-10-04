<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\Collections\{
        ArrayList,
        Dictionary
    };
    use System\Globalization\{
        CultureInfo
    };
    {
        echo '
            <h2>Testing <code>ArrayList</code>-, <code>Enumerable</code>- and <code>Enumerator</code>-Functionalities</h2>';
        echo '
            <p>
                Initializing a new <code>ArrayList</code> <code>$array</code>
            </p>';
        
        global $array, $ordered, $reversed, $us, $gb, $ch, $de;
        $array = new ArrayList();

        $us = new CultureInfo('en-US');
        $gb = new CultureInfo('en-GB');
        $ch = new CultureInfo('de-CH');
        $de = new CultureInfo('de-DE');

        $array->Add($us);
        $array->Add($gb);
        $array->Add($de);
        $array->Add($ch);
        $array->Add($ch);

        var_dump($array->ToArray());

        echo '
            <h3>Testing <code>Enumerator</code>-Functionalities</h3>
            <p>
                Initializing its enumerator <code>$enumerator</code>
            </p>';
        
        RunTest('$enumerator = $array->GetEnumerator()');
        RunTest('$enumerator->Current', $array[0]);
        RunTest('$enumerator->MoveNext()');
        RunTest('$enumerator->Current', $array[1]);
        RunTest('$enumerator->Reset()');
        RunTest('$enumerator->Current', $array[0]);

        echo '
            <h3>Testing <code>Enumerable</code>-Functionalities</h3>';

        RunTest('
            $array->All(function ($item)
            {
                return $item !== null;
            })', true);
        RunTest('
            $array->Any(function ($item)
            {
                return $item === null;
            })', false);
        RunTest('$array->Contains($ch)', true);
        RunTest('$array->Count()', 5);
        RunTest('
            $array->Count(function ($item)
            {
                return $item->Name == "de-CH";
            })', 2);
        RunTest('$array->First()', $array[0]);
        RunTest('
            $array->First(function ($item) use ($ch)
            {
                return $item == $ch;
            })', $ch);
        RunTest('
            $array->FirstOrDefault(function ($item)
            {
                return $item->Name == "de-AT";
            })', null);
        RunTest('$array->Last()', $array[$array->Count() - 1]);
        RunTest('
            $array->Last(function ($item)
            {
                return strncmp((string)$item, "de", 2) == 0;
            })', $ch);
        RunTest('
            $array->LastOrDefault(function ($item)
            {
                return strncmp((string)$item, "fr", 2) == 0;
            })', null);
        RunTest('$array->Insert(0, new System\Globalization\CultureInfo("fr-CH"))');
        RunTest('$array->Max()->ToString()', 'fr-CH');
        RunTest('$array->RemoveAt(0)');
        RunTest('
            $array->Max(function ($item)
            {
                return strlen($item->Name);
            })', 5);
        RunTest('
            $array->Min(function ($item)
            {
                return ord($item->Name[0]);
            })', 100);
        RunTest('$array->Min()->ToString()', 'de-CH');
        RunTest('
            $array->SequenceEqual(
                new System\Collections\ArrayList(
                    array(
                        $us,
                        $gb,
                        $de,
                        $ch,
                        $ch)))', true);
        RunTest('
            $array->Sum(function ($item)
            {
                return strlen($item->Name);
            })', 25);
        RunTest('
        (
            new \ReflectionClass(
                $array->ToDictionary(
                    function ($item)
                    {
                        return mt_rand();
                    })))->name', (new \ReflectionClass(new Dictionary()))->name);
        RunTest('(new \ReflectionClass($array->ToList()))->name', (new \ReflectionClass(new ArrayList()))->name);

        echo '
            <h4>Testing <code>Enumerable</code>-manipulations</h4>
            <p>
                Initializing a new <code>Enumerable</code> <code>$array</code>
            </p>';
        $array = (new ArrayList(range('A', 'F')))->OrderBy(function ($item)
        {
            return mt_rand();
        })->ToList();
        var_dump($array->ToArray());
        RunTest('$ordered = $array->OrderBy(function ($item)
        {
            return $item;
        })');
        RunTest('$ordered->First()', 'A');
        RunTest('$ordered->Last()', 'F');
        echo '
            <p>
                The ordered collection will include all changes made to the <code>$array</code> even if they\'re invoked <i>after</i> initializing the ordered collection.<br />
                Have a look at the next test.
            </p>';
        RunTest('$array->Add("_Apocalypse")');
        RunTest('$ordered->First()', '_Apocalypse');
        RunTest('$array->Remove("_Apocalypse")');
        RunTest('$descending = $array->OrderByDescending(function ($item)
        {
            return $item;
        })');
        RunTest('$reversed = $ordered->Reverse()');
        RunTest('$array->Add("Z")');
        RunTest('$descending->First()', 'Z');
        RunTest('$reversed->First()', 'Z');
        RunTest('$arrayWrapper = new System\Collections\ArrayList()');
        RunTest('
            $manySelector = $arrayWrapper->SelectMany(
                function ($item)
                {
                    return $item;
                })');
        RunTest('$arrayWrapper->AddRange(array($ordered, $reversed))');
        RunTest('$manySelector->Count()', $ordered->Count() + $reversed->Count());
        RunTest('$test = $ordered->Skip(2)');
        RunTest('$test->First()', 'C');
        RunTest('$array->Add("_test")');
        RunTest('$test->First()', 'B');
        RunTest('$array->Remove("_test")');
        RunTest('
            $test = $ordered->SkipWhile(function ($item)
            {
                return $item[0] == "A";
            })');
        RunTest('$test->First()[0] != "A"', true);
        RunTest('$test = $ordered->Take(1)');
        RunTest('$array->Insert(0, "_test")');
        RunTest('$test->First()', '_test');
        RunTest('$array->Remove("_test")');
        RunTest('
            $test = $ordered->TakeWhile(function ($item)
            {
                return $item[0] == "A";
            })');
        RunTest('
            $test->All(function ($item)
            {
                return $item[0] == "A";
            })', true);
        RunTest('
            $test = $array->Where(function ($item)
            {
                return strlen($item) > 10;
            })');
        RunTest('$array->AddRange(array("this is a very long string", "this here is a very long string, too"))');
        RunTest('$test->Count()', 2);
        RunTest('
            $array->RemoveAll(function ($item)
            {
                return strlen($item) > 10;
            })');
        RunTest('$distinct = $array->Distinct()');
        RunTest('$array->AddRange(array("Test", "Test", "Test", "Test", "Test"))');
        RunTest('
            $distinct->Count(
                function ($item)
                {
                    return $item == "Test";
                })', 1);

        echo '
            <h3>Testing <code>ArrayList</code>-Functionalities</h3>';
        RunTest('$array = new System\Collections\ArrayList()');
        RunTest('$array->Add("A")');
        RunTest('$array->Count', 1);
        RunTest('$array->AddRange(array("B", "C"))');
        RunTest('$array->AddRange(new System\Collections\ArrayList(array("D", "E")))');
        RunTest('$array->Count', 5);
        RunTest('$array->Clear()');
        RunTest('$array->Count', 0);
        RunTest('$array->AddRange(array("A", "B", "C"))');
        RunTest('$array->Contains("B")', true);
        RunTest('
            $array->ConvertAll(
                function ($item)
                {
                    return strlen($item);
                })->First()', 1);
        RunTest('$second = new System\Collections\ArrayList(array("X", "Y", "Z"))');
        RunTest('$second->CopyTo($array, 0, 0, 3)');
        RunTest('$array[2]', 'Z');
        RunTest('$array->Clear()');
        RunTest('$array->AddRange(range("A", "C"))');
        RunTest('
            $array->Exists(
                function ($item)
                {
                    return $item == "D";
                })', false);
        RunTest('
            $array->Find(
                function ($item)
                {
                    return $item == "B";
                })', "B");
        RunTest('
            $array->FindAll(
                function ($item)
                {
                    return ord($item) > ord("A");
                })->Count', 2);
        RunTest('
            $array->FindIndex(
                function ($item)
                {
                    return $item == "Z";
                })', -1);
        RunTest('
            $array->FindLast(
                function ($item)
                {
                    return $item == "Y";
                })', null);
        RunTest('$array->Insert(2, "A")');
        RunTest('
            $array->FindLastIndex(
                function ($item)
                {
                    return $item == "A";
                })', 2);
        RunTest('$array = $array->Distinct()->ToList()');
        RunTest('$ord = null');
        RunTest('
            $array->ForEach(
                function ($item)
                {
                    global $ord;
                    $ord = ord($item);
                })');
        RunTest('$ord', ord($array->Last()));
        RunTest('$array->GetRange(1, 2)->First()', 'B');
        RunTest('$array->IndexOf("B")', 1);
        RunTest('$array->Insert(3, "D")');
        RunTest('$array[3]', 'D');
        RunTest('$array->InsertRange(4, array("X", "Y", "Z"))');
        RunTest('$array->Contains("X") && $array->Contains("Y") && $array->Contains("Z")', true);
        RunTest('$array = new System\Collections\ArrayList(range("A", "C"))');
        RunTest('$array->Add("A")');
        RunTest('$array->LastIndexOf("A")', 3);
        RunTest('$array->Remove("B")');
        RunTest('$array->Contains("B")', false);
        RunTest('
            $array->RemoveAll(
                function ($item)
                {
                    return $item == "A";
                })');
        RunTest('$array->Contains("A")', false);
        RunTest('$array->RemoveAt(0)');
        RunTest('$array->Contains("C")', false);
        RunTest('$array->AddRange(range("A", "Z"))');
        RunTest('$array->RemoveRange(0, 3)');
        RunTest('$array->Contains("A") || $array->Contains("B") || $array->Contains("C")', false);
        RunTest('
            $array = $array->OrderBy(
                function ($item)
                {
                    return mt_rand();
                })->ToList()');
        RunTest('$array->Sort()');
        RunTest('$array->First() == "D" && $array->Last() == "Z"', true);
        RunTest('
            $array->TrueForAll(
                function ($item)
                {
                    return is_string($item);
                })', true);

        
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