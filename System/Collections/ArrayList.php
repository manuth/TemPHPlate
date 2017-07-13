<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\{
        ArgumentException,
        ArgumentNullException,
        ArgumentOutOfRangeException,
        NotImplementedException
    };
    {
        /**
         * Represents a list of objects that can be accessed by index. Provides methods to search, sort, and manipulate lists.
         * 
         * @property-read int $Count
         * Gets the number of elements contained in the ArrayList.
         */
        class ArrayList extends Enumerable implements \ArrayAccess
        {
            /**
             * The items of the list.
             *
             * @var array
             */
            protected $InnerList = array();

            /**
             * Initializes a new instance of the ArrayList class that is empty.
             */
            public function ArrayList()
            {
            }

            /**
             * Initializes a new instance of the ArrayList class that contains elements copied from the specified collection.
             *
             * @param Enumerable $collection
             * The collection whose elements are copied to the new list.
             */
            public function ArrayList1($collection)
            {
                $this->AddRange($collection);
            }

            /**
             * @ignore
             * @return int
             */
            public function getCount()
            {
                return $this->Count();
            }

            /**
             * Returns a value indicating whether the offset exists.
             *
             * @return bool
             * A value indicating whether the offset exists.
             */
            public function offsetExists($index)
            {
                return $index >= 0 && $index < $this->Count;
            }

            /**
             * Gets the element at the specified index.
             *
             * @param int $index
             * The index of the element to return.
             * 
             * @return mixed
             * The element at the specified index.
             */
            public function offsetGet($index)
            {
                if ($this->offsetExists($index))
                {
                    return $this->InnerList[$index];
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Sets the element at the specified index.
             *
             * @param int $index
             * The index of the element to return.
             * 
             * @param mixed $value
             * The value to set at the specified index.
             * 
             * @return void
             */
            public function offsetSet($index, $value)
            {
                if ($this->offsetExists($index))
                {
                    $this->InnerList[$index] = $value;
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Removes the element at the specified index.
             *
             * @param int $index
             * The index of the element to remove.
             * 
             * @return void
             */
            public function offsetUnset($index)
            {
                $this->RemoveAt($index);
            }

            /**
             * Adds an object to the end of the ArrayList.
             *
             * @param mixed $item
             * The object to be added to the end of the ArrayList. The value can be **null**.
             * 
             * @return void
             */
            public function Add($item)
            {
                $this->Insert($this->Count, $item);
            }

            /**
             * Adds the elements of the specified collection to the end of the ArrayList.
             *
             * @param Enumerable $ccollection
             * The collection whose elements should be added to the end of the ArrayList. The collection itself cannot be null, but it can contain elements that are null.
             * 
             * @return void
             */
            public function AddRange($collection)
            {
                $this->InsertRange($this->Count, $collection);
            }

            /**
             * Removes all elements from the ArrayList.
             *
             * @return void
             */
            public function Clear()
            {
                $this->InnerList = array();
            }

            /**
             * Determines whether an element is in the ArrayList.
             *
             * @param mixed $item
             * The object to locate in the ArrayList. The value can be **null**.
             * 
             * @return bool
             * **true** if item is found in the ArrayList; otherwise, **false**.
             */
            public function Contains($item)
            {
                return parent::Contains($item);
            }

            /**
             * Converts the elements in the current ArrayList to another type, and returns a list containing the converted elements.
             *
             * @param callable $converter
             * A converter delegate that converts each element from one type to another type.
             * 
             * @return ArrayList
             * An ArrayList of the target type containing the converted elements from the current ArrayList.
             */
            public function ConvertAll(callable $converter)
            {
                return $this->Select($converter)->ToList();
            }

            /**
             * Copies the entire ArrayList to a compatible one-dimensional array, starting at the specified index of the target array.
             *
             * @param mixed $array
             * The one-dimensional array that is the destination of the elements copied from List<T>. The Array must have zero-based indexing.
             * 
             * @param int $arrayIndex
             * The zero-based index in array at which copying begins.
             * 
             * @param int $index
             * The zero-based index in the source ArrayList at which copying begins.
             * 
             * @param int $count
             * The number of elements to copy.
             * 
             * @return void
             */
            public function CopyTo($array, $arrayIndex = 0, $index = 0, $count = null)
            {
                if ($count === null)
                {
                    $count = $this->Count;
                }

                if ($array !== null)
                {
                    if ($index >= 0)
                    {
                        if ($arrayIndex >= 0)
                        {
                            if ($count >= 0)
                            {
                                if (($arrayIndex + $count <= count($array)) && ($index + $count <= $this->Count))
                                {
                                    for ($i = 0; $i < $count; $i++)
                                    {
                                        $array[$arrayIndex + $i] = $this[$index + $i];
                                    }
                                }
                                else
                                {
                                    throw new ArgumentException();
                                }
                            }
                            else
                            {
                                throw new ArgumentOutOfRangeException('count', $count);
                            }
                        }
                        else
                        {
                            throw new ArgumentOutOfRangeException('arrayIndex', $arrayIndex);
                        }
                    }
                    else
                    {
                        throw new ArgumentOutOfRangeException('index', $index);
                    }
                }
                else
                {
                    throw new ArgumentNullException('array');
                }
            }

            /**
             * Determines whether the ArrayList contains elements that match the conditions defined by the specified predicate.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the elements to search for.
             * 
             * @return bool
             * **true** if the ArrayList contains one or more elements that match the conditions defined by the specified predicate; otherwise, **false**.
             */
            public function Exists(callable $match)
            {
                if ($match !== null)
                {
                    return $this->Any($match);
                }
                else
                {
                    throw new ArgumentNullException('match');
                }
            }

            /**
             * Searches for an element that matches the conditions defined by the specified predicate, and returns the first occurrence within the entire ArrayList.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the element to search for.
             * 
             * @return mixed
             * The first element that matches the conditions defined by the specified predicate, if found; otherwise, **null**.
             */
            public function Find(callable $match)
            {
                $index = $this->FindIndex($match);

                if ($index >= 0)
                {
                    return $this[$index];
                }
                else
                {
                    return null;
                }
            }

            /**
             * Retrieves all the elements that match the conditions defined by the specified predicate.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the elements to search for.
             * 
             * @return ArrayList
             * An ArrayList containing all the elements that match the conditions defined by the specified predicate, if found; otherwise, an empty ArrayList.
             */
            public function FindAll(callable $match)
            {
                if ($match !== null)
                {
                    return $this->Where($match)->ToList();
                }
                else
                {
                    throw new ArgumentNullException('match');
                }
            }

            /**
             * Searches for an element that matches the conditions defined by the specified predicate, and returns the zero-based index of the first occurrence within the entire ArrayList.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the element to search for.
             * 
             * @return int
             * The zero-based index of the first occurrence of an element that matches the conditions defined by _match_, if found; otherwise, –1.
             */
            public function FindIndex(callable $match)
            {
                if ($match !== null)
                {
                    for ($i = 0; $i < $this->Count; $i++)
                    {
                        if ($match($this[$i]))
                        {
                            return $i;
                        }
                    }

                    return -1;
                }
                else
                {
                    throw new ArgumentNullException('match');
                }
            }

            /**
             * Searches for an element that matches the conditions defined by the specified predicate, and returns the last occurrence within the entire ArrayList.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the element to search for.
             * 
             * @return mixed
             * The last element that matches the conditions defined by the specified predicate, if found; otherwise, **null**.
             */
            public function FindLast(callable $match)
            {
                $index = $this->FindLastIndex($match);

                if ($index >= 0)
                {
                    return $this[$index];
                }
                else
                {
                    return null;
                }
            }

            /**
             * Searches for an element that matches the conditions defined by the specified predicate, and returns the zero-based index of the last occurrence within the entire ArrayList.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the element to search for.
             * 
             * @return int
             * The zero-based index of the last occurrence of an element that matches the conditions defined by _match_, if found; otherwise, –1.
             */
            public function FindLastIndex(callable $match)
            {
                if ($match !== null)
                {
                    for ($i = $this->Count - 1; $i >= 0; $i--)
                    {
                        if ($match($this[$i]))
                        {
                            return $i;
                        }
                    }

                    return -1;
                }
                else
                {
                    throw new ArgumentNullException('match');
                }
            }

            /**
             * Performs the specified action on each element of the ArrayList.
             *
             * @param callable $action
             * The action delegate to perform on each element of the ArrayList.
             * 
             * @return void
             */
            public function ForEach(callable $action)
            {
                if ($action !== null)
                {
                    foreach ($this as $item)
                    {
                        $action($item);
                    }
                }
                else
                {
                    throw new ArgumentNullException('action');
                }
            }

            /**
             * Returns an enumerator that iterates through the collection.
             *
             * @return Enumerator
             */
            public function GetEnumerator()
            {
                return new Enumerator(function ()
                {
                    foreach ($this->InnerList as $value)
                    {
                        yield $value;
                    }
                });
            }

            /**
             * Creates a shallow copy of a range of elements in the source ArrayList.
             *
             * @param int $index
             * The zero-based ArrayList index at which the range starts.
             * 
             * @param int $count
             * The number of elements in the range.
             * 
             * @return ArrayList
             * A shallow copy of a range of elements in the source ArrayList.
             */
            public function GetRange($index, $count)
            {
                if ($index >= 0)
                {
                    if ($count >= 0)
                    {
                        if ($index + $count <= $this->Count)
                        {
                            return $this->Skip($index)->Take($count)->ToList();
                        }
                        else
                        {
                            throw new ArgumentException();
                        }
                    }
                    else
                    {
                        throw new ArgumentOutOfRangeException('count', $count);
                    }
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Searches for the specified object and returns the zero-based index of the first occurrence within the entire ArrayList.
             *
             * @param mixed $item
             * The object to locate in the ArrayList. The value can be null.
             * 
             * @return int
             * The zero-based index of the first occurrence of item within the entire ArrayList, if found; otherwise, –1.
             */
            public function IndexOf($item)
            {
                return $this->FindIndex(function ($entry) use ($item)
                {
                    return $entry === $item;
                });
            }

            /**
             * Inserts an element into the ArrayList at the specified index.
             *
             * @param int $index
             * The zero-based index at which item should be inserted.
             * 
             * @param mixed $item
             * The object to insert. The value can be **null**.
             * 
             * @return void
             */
            public function Insert($index, $item)
            {
                if ($index >= 0 && $index <= $this->Count)
                {
                    array_splice($this->InnerList, $index, 0, array($item));
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Inserts the elements of a collection into the ArrayList at the specified index.
             *
             * @param int $index
             * The zero-based index at which the new elements should be inserted.
             * 
             * @param Enumerable $collection
             * The collection whose elements should be inserted into the ArrayList. The collection itself cannot be **null**, but it can contain elements that are null.
             * 
             * @return void
             */
            public function InsertRange($index, $collection)
            {
                if ($collection !== null)
                {
                    if (is_array($collection))
                    {
                        $array = $collection;
                        $collection = new EnumerableIterator(function () use ($array)
                        {
                            foreach ($array as $value)
                            {
                                yield $value;
                            }
                        });
                    }

                    if ($index >= 0 && $index <= $this->Count)
                    {
                        $enumerator = $collection->GetEnumerator();

                        for ($i = 0; $enumerator->Valid; $i++)
                        {
                            $this->Insert($index + $i, $enumerator->Current);
                            $enumerator->MoveNext();
                        }
                    }
                    else
                    {
                        throw new ArgumentOutOfRangeException('index', $index);
                    }
                }
                else
                {
                    throw new ArgumentNullException('collection');
                }
            }

            /**
             * Searches for the specified object and returns the zero-based index of the last occurrence within the entire ArrayList.
             *
             * @param mixed $item
             * The object to locate in the ArrayList. The value can be **null**.
             * 
             * @return int
             * The zero-based index of the last occurrence of item within the entire the ArrayList, if found; otherwise, –1.
             */
            public function LastIndexOf($item)
            {
                return $this->FindLastIndex(function ($entry) use ($item)
                {
                    return $entry === $item;
                });
            }

            /**
             * Removes the first occurrence of a specific object from the ArrayList.
             *
             * @param mixed $item
             * The object to remove from the ArrayList. The value can be **null**.
             * 
             * @return bool
             * **true** if item is successfully removed; otherwise, **false**. This method also returns **false** if item was not found in the ArrayList.
             */
            public function Remove($item)
            {
                $index = $this->IndexOf($item);

                if ($index >= 0)
                {
                    $this->RemoveAt($this->IndexOf($item));
                    return true;
                }
                else
                {
                    return false;
                }
            }

            /**
             * Removes all the elements that match the conditions defined by the specified predicate.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions of the elements to remove.
             * 
             * @return int
             * The number of elements removed from the ArrayList.
             */
            public function RemoveAll(callable $match)
            {
                $count = 0;

                foreach ($this->Where($match) as $item)
                {
                    if ($this->Remove($item))
                    {
                        $count++;
                    }
                }

                return $count;
            }

            /**
             * Removes the element at the specified index of the ArrayList.
             *
             * @param int $index
             * The zero-based index of the element to remove.
             * 
             * @return void
             */
            public function RemoveAt($index)
            {
                if ($this->offsetExists($index))
                {
                    $this->RemoveRange($index, 1);
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Removes a range of elements from the ArrayList.
             *
             * @param int $index
             * The zero-based starting index of the range of elements to remove.
             * 
             * @param int $count
             * The number of elements to remove.
             * 
             * @return void
             */
            public function RemoveRange($index, $count)
            {
                if ($index >= 0)
                {
                    if ($count >= 0)
                    {
                        if (($index + $count) <= $this->Count)
                        {
                            array_splice($this->InnerList, $index, $count);
                        }
                        else
                        {
                            throw new ArgumentException();
                        }
                    }
                    else
                    {
                        throw new ArgumentOutOfRangeException('count', $count);
                    }
                }
                else
                {
                    throw new ArgumentOutOfRangeException('index', $index);
                }
            }

            /**
             * Sorts the elements in the entire ArrayList using the default comparer.
             * 
             * @param callable $comparer
             * The comparer implementation to use when comparing elements, or **null** to use the default comparer.
             *
             * @return void
             */
            public function Sort(callable $comparer = null)
            {
                $this->InnerList = $this->OrderBy(function ($item)
                {
                    return $item;
                }, $comparer)->ToArray();
            }

            /**
             * Copies the elements of the ArrayList to a new array.
             *
             * @return mixed[]
             * An array containing copies of the elements of the ArrayList.
             */
            public function ToArray()
            {
                return parent::ToArray();
            }

            /**
             * Determines whether every element in the ArrayList matches the conditions defined by the specified predicate.
             *
             * @param callable $match
             * The predicate delegate that defines the conditions to check against the elements.
             * 
             * @return bool
             * **true** if every element in the ArrayList matches the conditions defined by the specified predicate; otherwise, **false**. If the list has no elements, the return value is **true**.
             */
            public function TrueForAll(callable $match)
            {
                if ($match !== null)
                {
                    return $this->All($match);
                }
                else
                {
                    throw new ArgumentNullException('match', $match);
                }
            }
        }
    }
?>