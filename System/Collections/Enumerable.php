<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\Object;
    use System\{
        ArgumentException,
        ArgumentNullException,
        ArgumentOutOfRangeException,
        InvalidOperationException,
        IObject,
        NotImplementedException
    };
    {
        /**
         * Represents a collection of items.
         */
        abstract class Enumerable extends Object implements \IteratorAggregate, \Countable
        {
            /**
             * Initializes a new instance of the Enumerable class.
             */
            public function Enumerable()
            {
            }

            /**
             * Returns an enumerator that iterates through the collection.
             *
             * @return Enumerator
             */
            public function getIterator()
            {
                return $this->GetEnumerator();
            }

            /**
             * Returns an enumerator that iterates through the collection.
             *
             * @return Enumerator
             */
            public abstract function GetEnumerator();
            
            /**
             * Determines whether all elements of a sequence satisfy a condition.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return bool
             * **true** if every element of the source sequence passes the test in the specified predicate, or if the sequence is empty; otherwise, **false**.
             */
            public function All(callable $predicate)
            {
                return !$this->Any(function ($entry) use ($predicate)
                {
                    return !$predicate($entry);
                });
            }

            /**
             * Determines whether any element of a sequence satisfies a condition.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return bool
             * **true** if any elements in the source sequence pass the test in the specified predicate; otherwise, **false**.
             */
            public function Any(callable $predicate = null)
            {
                if ($predicate === null)
                {
                    $predicate = function ($item)
                    {
                        return true;
                    };
                }

                $enumerator = $this->Where($predicate)->GetEnumerator();
                return $enumerator->Valid;
            }

            /**
             * Determines whether a sequence contains a specified element by using the default equality comparer.
             *
             * @param mixed $value
             * The value to locate in the sequence.
             * 
             * @return bool
             * **true** if the source sequence contains an element that has the specified value; otherwise, **false**.
             */
            public function Contains($value)
            {
                return $this->Any(function ($item) use ($value)
                {
                    return EqualityComparer::$Default->Equals($item, $value);
                });
            }

            /**
             * Returns the number of elements in a sequence.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return int
             * The number of elements in the input sequence.
             */
            public function Count(callable $predicate = null)
            {
                if ($predicate === null)
                {
                    $predicate = function ($item)
                    {
                        return true;
                    };
                }

                $count = 0;
                $enumerator = $this->Where($predicate)->GetEnumerator();

                while ($enumerator->Valid)
                {
                    $count++;
                    $enumerator->MoveNext();
                }

                return $count;
            }

            /**
             * Returns distinct elements from a sequence by using a specified EqualityComparer to compare values.
             *
             * @param EqualityComparer $comparer
             * An EqualityComparer to compare values.
             * 
             * @return void
             */
            public function Distinct(EqualityComparer $comparer = null)
            {
                return new EnumerableIterator(
                    function() use ($comparer)
                    {
                        $set = new Set($comparer);

                        foreach ($this as $item)
                        {
                            if ($set->Add($item))
                            {
                                yield $item;
                            }
                        }
                    });
            }

            /**
             * Returns the first element in a sequence that satisfies a specified condition.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return mixed
             * The first element in the sequence that passes the test in the specified predicate function.
             */
            public function First(callable $predicate = null)
            {
                if ($predicate === null)
                {
                    $predicate = function ($item)
                    {
                        return true;
                    };
                }

                $enumerator = $this->Where($predicate)->GetEnumerator();

                if ($enumerator->Valid)
                {
                    return $enumerator->Current;
                }
                else
                {
                    throw new InvalidOperationException();
                }
            }

            /**
             * Returns the first element of the sequence that satisfies a condition or a default value if no such element is found.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return mixed
             * **null** if no element passes the test specified by predicate; otherwise, the first element in source that passes the test specified by predicate.
             */
            public function FirstOrDefault(callable $predicate = null)
            {
                try
                {
                    return $this->First($predicate);
                }
                catch (InvalidOperationException $exception)
                {
                    return null;
                }
            }

            /**
             * Returns the last element of a sequence that satisfies a specified condition.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return mixed
             * The last element in the sequence that passes the test in the specified predicate function.
             */
            public function Last(callable $predicate = null)
            {
                if ($predicate === null)
                {
                    $predicate = function ($item)
                    {
                        return true;
                    };
                }

                $array = $this->Where($predicate)->ToArray();

                if (count($array) > 0)
                {
                    return $array[count($array) - 1];
                }
                else
                {
                    throw new InvalidOperationException();
                }
            }

            /**
             * Returns the last element of a sequence that satisfies a condition or a default value if no such element is found.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return mixed
             * **null** if the sequence is empty or if no elements pass the test in the predicate function; otherwise, the last element that passes the test in the predicate function.
             */
            public function LastOrDefault(callable $predicate = null)
            {
                try
                {
                    return $this->Last($predicate);
                }
                catch (InvalidOperationException $exception)
                {
                    return null;
                }
            }

            /**
             * Invokes a transform function on each element of a sequence and returns the maximum int value.
             *
             * @param callable $selector
             * A transform function to apply to each element.
             * 
             * @return int
             * The maximum value in the sequence.
             */
            public function Max(callable $selector = null)
            {
                if ($selector === null)
                {
                    $selector = function ($item)
                    {
                    return $item;
                    };
                }

                $enumerator = $this->Select($selector)->OrderByDescending(
                    function ($item)
                    {
                        return $item;
                })->GetEnumerator();

                if ($enumerator->Valid)
                {
                    return $enumerator->Current;
                }
                else
                {
                    throw new InvalidOperationException();
                }
            }

            /**
             * Invokes a transform function on each element of a sequence and returns the minimum Int32 value.
             *
             * @param callable $selector
             * A transform function to apply to each element.
             * 
             * @return int
             * The minimum value in the sequence.
             */
            public function Min(callable $selector = null)
            {
                if ($selector === null)
                {
                    $selector = function ($item)
                    {
                    return $item;
                    };
                }

                $enumerator = $this->Select($selector)->OrderBy(
                    function ($item)
                    {
                        return $item;
                })->GetEnumerator();

                if ($enumerator->Valid)
                {
                    return $enumerator->Current;
                }
                else
                {
                    throw new InvalidOperationException();
                }
            }

            /**
             * Sorts the elements of a sequence in ascending order according to a key.
             *
             * @param callable $keySelector
             * A function to extract a key from an element.
             *
             * @param Comparer $comparer
             * A Comparer to compare keys.
             * 
             * @return Enumerable
             * An Enumerable whose elements are sorted according to a key.
             */
            public function OrderBy(callable $keySelector, Comparer $comparer = null)
            {
                return $this->OrderByInternal($keySelector, $comparer, false);
            }

            /**
             * Sorts the elements of a sequence in descending order according to a key.
             *
             * @param callable $keySelector
             * A function to extract a key from an element.
             * 
             * @param Comparer $comparer
             * A comparer to compare keys.
             * 
             * @return Enumerable
             * An Enumerable whose elements are sorted in descending order according to a key.
             */
            public function OrderByDescending(callable $keySelector, Comparer $comparer = null)
            {
                return $this->OrderByInternal($keySelector, $comparer, true);
            }

            /**
             * Inverts the order of the elements in a sequence.
             *
             * @return Enumerable
             * A sequence whose elements correspond to those of the input sequence in reverse order.
             */
            public function Reverse()
            {
                return new EnumerableIterator(function ()
                {
                    foreach (array_reverse($this->ToArray()) as $value)
                    {
                        yield $value;
                    }
                });
            }

            /**
             * Projects each element of a sequence into a new form.
             *
             * @param callable $selector
             * A transform function to apply to each element.
             * 
             * @return Enumerable
             * An Enumerable whose elements are the result of invoking the transform function on each element of _source_.
             */
            public function Select(callable $selector)
            {
                return new EnumerableIterator(function () use ($selector)
                {
                    foreach ($this as $value)
                    {
                        yield $selector($value);
                    }
                });
            }

            /**
             * Projects each element of a sequence to an Enumerable and flattens the resulting sequences into one sequence.
             *
             * @param callable $selector
             * A transform function to apply to each element.
             * 
             * @return Enumerable
             * An Enumerable whose elements are the result of invoking the one-to-many transform function on each element of the input sequence.
             */
            public function SelectMany(callable $selector)
            {
                return new EnumerableIterator(function () use ($selector)
                {
                    foreach ($this->Select($selector) as $value)
                    {
                        foreach ($value as $item)
                        {
                            yield $item;
                        }
                    }
                });
            }

            /**
             * Determines whether two sequences are equal by comparing the elements by using the default equality comparer for their type.
             *
             * @param Enumerable $second
             * An Enumerable to compare to the first sequence.
             * 
             * @return bool
             * true if the two source sequences are of equal length and their corresponding elements are equal according to the default equality comparer for their type; otherwise, **false**.
             */
            public function SequenceEqual($second)
            {
                $xIterator = $this->GetEnumerator();
                $yIterator = $second->GetEnumerator();

                while ($xIterator->Valid && $yIterator->Valid)
                {
                    if (!EqualityComparer::$Default->Equals($xIterator->Current, $yIterator->Current))
                    {
                        return false;
                    }

                    $xIterator->MoveNext();
                    $yIterator->MoveNext();
                }

                return $xIterator->Valid == $yIterator->Valid;
            }

            /**
             * Bypasses a specified number of elements in a sequence and then returns the remaining elements.
             *
             * @param int $count
             * The number of elements to skip before returning the remaining elements.
             * 
             * @return Enumerable
             * An Enumerable that contains the elements that occur after the specified index in the input sequence.
             */
            public function Skip($count)
            {
                return new EnumerableIterator(function () use ($count)
                {
                    $enumerator = $this->GetEnumerator();

                    for ($i = 0; $i < $count; $i++)
                    {
                        $enumerator->MoveNext();
                    }

                    while ($enumerator->Valid)
                    {
                        yield $enumerator->Current;
                        $enumerator->MoveNext();
                    }
                });
            }

            /**
             * Bypasses elements in a sequence as long as a specified condition is true and then returns the remaining elements.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return Enumerable
             * An Enumerable that contains the elements from the input sequence starting at the first element in the linear series that does not pass the test specified by _predicate_.
             */
            public function SkipWhile(callable $predicate)
            {
                return new EnumerableIterator(function () use ($predicate)
                {
                    $enumerator = $this->GetEnumerator();

                    while ($enumerator->Valid && $predicate($enumerator->Current))
                    {
                        $enumerator->MoveNext();
                    }

                    while ($enumerator->Valid)
                    {
                        yield $enumerator->Current;
                        $enumerator->Next();
                    }
                });
            }

            /**
             * Computes the sum of the sequence of int values that are obtained by invoking a transform function on each element of the input sequence.
             *
             * @param callable $selector
             * A transform function to apply to each element.
             * 
             * @return int
             * The sum of the projected values.
             */
            public function Sum(callable $selector)
            {
                $result = 0;

                foreach ($this->Select($selector) as $item)
                {
                    $result += $item;
                }

                return $result;
            }

            /**
             * Returns a specified number of contiguous elements from the start of a sequence.
             *
             * @param int $count
             * The number of elements to return.
             * 
             * @return Enumerable
             * An Enumerable that contains the specified number of elements from the start of the input sequence.
             */
            public function Take($count)
            {
                return new EnumerableIterator(function () use ($count)
                {
                    $enumerator = $this->GetEnumerator();
                    
                    for ($i = 0; $i < $count && $enumerator->Valid; $i++)
                    {
                        yield $enumerator->Current;
                        $enumerator->MoveNext();
                    }
                });
            }

            /**
             * Returns elements from a sequence as long as a specified condition is true.
             *
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return Enumerable
             * An Enumerable that contains the elements from the input sequence that occur before the element at which the test no longer passes.
             */
            public function TakeWhile(callable $predicate)
            {
                return new EnumerableIterator(function () use ($predicate)
                {
                    $enumerator = $this->GetEnumerator();

                    while ($enumerator->Valid && $predicate($enumerator->Current))
                    {
                        yield $enumerator->Current;
                        $enumerator->MoveNext();
                    }
                });
            }

            /**
             * Creates an array from an Enumerable.
             *
             * @return array
             * An array that contains the elements from the input sequence.
             */
            public function ToArray()
            {
                $array = array();

                foreach ($this as $key => $entry)
                {
                    $array[$key] = $entry;
                }
                
                return $array;
            }

            public function ToDictionary()
            {
                throw new NotImplementedException();
            }

            /**
             * Creates an ArrayList from an Enumerable.
             *
             * @return ArrayList
             */
            public function ToList()
            {
                return new ArrayList($this);
            }

            /**
             * Filters a sequence of values based on a predicate.
             * 
             * @param callable $predicate
             * A function to test each element for a condition.
             * 
             * @return Enumerable
             * An Enumerable that contains elements from the input sequence that satisfy the condition.
             */
            public function Where(callable $predicate)
            {
                if ($predicate !== null)
                {
                    return new EnumerableIterator(function () use ($predicate)
                    {
                        foreach ($this as $value)
                        {
                            if ($predicate($value))
                            {
                                yield $value;
                            }
                        }
                    });
                }
                else
                {
                    throw new ArgumentNullException('predicate');
                }
            }

            /**
             * Sorts the elements of a sequence in the specified order according to a key.
             *
             * @param callable $keySelector
             * A function to extract a key from an element.
             * 
             * @param Comparer $comparer
             * A comparar to compare keys.
             * 
             * @param bool $descending
             * A value indicating whether to sort in the descending order.
             * 
             * @return Enumerable
             * An Enumerable whose elements are sorted according to a key.
             */
            private function OrderByInternal(callable $keySelector, Comparer $comparer = null, $descending)
            {
                if ($keySelector !== null)
                {
                    if ($comparer === null)
                    {
                        $comparer = Comparer::$Default;
                    }

                    return new EnumerableIterator(function () use ($keySelector, $comparer, $descending)
                    {
                        $array = $this->ToArray();

                        usort($array, function ($x, $y) use ($keySelector, $comparer, $descending)
                        {
                            return $comparer->Compare($keySelector($x), $keySelector($y)) * ($descending ? -1 : 1);
                        });

                        foreach ($array as $value)
                        {
                            yield $value;
                        }
                    });
                }
                else
                {
                    throw new ArgumentNullException('keySelector');
                }
            }
        }

        /**
         * Represents a set of distinct items.
         */
        class Set extends Object
        {
            /**
             * A set of distinct items.
             *
             * @var ArrayList
             */
            private $innerList;
            
            /**
             * A comparer for comparing items.
             *
             * @var callable
             */
            private $comparer;

            /**
             * Initializes a new instance of the Set class.
             */
            public function Set()
            {
                $this->This(null);
            }

            /**
             * Initializes a new instance of the Set class.
             *
             * @param EqualityComparer $comparer
             * The comparer for comparing items.
             */
            public function Set1(EqualityComparer $comparer = null)
            {
                if ($comparer === null)
                {
                    $comparer = new EqualityComparer(
                        function ($x, $y)
                        {
                            return $x === $y;
                        });
                }

                $this->comparer = $comparer;
                $this->innerList = new ArrayList();
            }

            /**
             * Adds the value to the set if it doesn't exist.
             *
             * @param mixed $value
             * The value to add to the set.
             * 
             * @return bool
             * **true** if the value doesn't exist inside the Set and could be added; otherwise **false**.
             */
            public function Add($value)
            {
                return !$this->Find($value, true);
            }

            /**
             * Determines whether the Set contains the specified value.
             *
             * @param mixed $value
             * The value to locate in the Set.
             * 
             * @return bool
             * **true** if the Set contains an element that has the specified value; otherwise, **false**.
             */
            public function Contains($value)
            {
                return $this->Find($value, false);
            }

            /**
             * Removes the first occurrence of a specific object from the Set.
             *
             * @param mixed $item
             * The object to remove from the Set. The value can be **null**.
             * 
             * @return bool
             * **true** if item is successfully removed; otherwise, **false**. This method also returns **false** if item was not found in the Set.
             */
            public function Remove($value)
            {
                return $this->innerList->Remove($value);
            }

            /**
             * Determines whether the Set contains the specified value.
             *
             * @param mixed $value
             * The value to locate in the Set.
             * 
             * @param bool $add
             * Indicates whether the item should be added to the sequence if it doesn't exist.
             * 
             * @return bool
             * **true** if the Set contains an element that has the specified value; otherwise, **false**.
             */
            private function Find($value, $add)
            {
                if ($this->innerList->Any(
                    function ($item) use ($value)
                    {
                        return $this->comparer->Equals($item, $value);
                    }))
                {
                    return true;
                }
                else
                {
                    if ($add)
                    {
                        $this->innerList->Add($value);
                    }

                    return false;
                }
            }
        }
    }
?>