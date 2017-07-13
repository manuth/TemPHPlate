<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\{
        ArgumentNullException,
        ArgumentException
    };
    {
        /**
         * Represents a collection of keys and values.
         * 
         * @property-read EqualityComparer $Comparer
         * Gets the EqualityComparer that is used to determine equality of keys for the dictionary.
         * 
         * @property-read int $Count
         * Gets the number of key/value pairs contained in the Dictionary.
         * 
         * @property-read Enumerable $Keys
         * Gets a collection containing the keys in the Dictionary.
         * 
         * @property-read Enumerable $Values
         * Gets a collection containing the values in the Dictionary.
         */
        class Dictionary extends Enumerable implements \ArrayAccess
        {
            /**
             * The Equality-Comparer that is used to determine equality of keys for the dictionary.
             *
             * @var EqualityComparer
             */
            private $comparer;

            /**
             * The items in the Dictionary.
             *
             * @var ArrayList
             */
            protected $InnerList;

            /**
             * Initializes a new instance of the Dictionary class that is empty and uses the default equality comparer.
             *
             * @return void
             */
            public function Dictionary()
            {
                $this->comparer = EqualityComparer::$Default;

                $this->InnerList = new ArrayList();
            }

            /**
             * Initializes a new instance of the Dictionary class that contains elements copied from the specified Dictionary and uses the default equality comparer.
             *
             * @param Dictionary $dictionary
             * The Dictionary whose elements are copied to the new Dictionary.
             */
            public function Dictionary1($dictionary)
            {
                $this->This();
                if ($dictionary !== null)
                {
                    if ($dictionary instanceof Dictionary)
                    {
                        foreach ($dictionary as $item)
                        {
                            $this->Add($item->Key, $item->Value);
                        }
                    }
                    else
                    {
                        foreach ($dictionary as $key => $value)
                        {
                            $this->Add($key, $value);
                        }
                    }
                }
                else
                {
                    throw new ArgumentNullException('dictionary');
                }
            }

            /**
             * Initializes a new instance of the Dictionary class that contains elements copied from the specified Dictionary and uses the specified EqualityComparer.
             *
             * @param Dictionary $dictionary
             * The Dictionary whose elements are copied to the new Dictionary.
             * 
             * @param EqualityComparer $comparer
             * The EqualityComparer implementation to use when comparing keys, or null to use the default EqualityComparer.
             */
            public function Dictionary2($dictionary, EqualityComparer $comparer)
            {
                $this->This();

                if ($comparer !== null)
                {
                    $this->comparer = $comparer;
                }
                else
                {
                    $this->comparer = EqualityComparer::$Default;
                }

                foreach ($dictionary as $item)
                {
                    $this->Add($item->Key, $item->Value);
                }
            }

            /**
             * @ignore
             * @return EqualityComparer
             */
            public function getComparer()
            {
                return $this->comparer;
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
             * @ignore
             * @return Enumerable
             */
            public function getKeys()
            {
                return new EnumerableIterator(function ()
                {
                    foreach ($this as $item)
                    {
                        yield $item->Key;
                    }
                });
            }

            /**
             * @ignore
             * @return Enumerable
             */
            public function getValues()
            {
                return new EnumerableIterator(function ()
                {
                    foreach ($this as $item)
                    {
                        yield $item->Value;
                    }
                });
            }

            /**
             * Returns a value indicating whether the offset exists.
             *
             * @return bool
             * A value indicating whether the offset exists.
             */
            public function offsetExists($key)
            {
                return $this->ContainsKey($key);
            }

            /**
             * Gets the element with the specified key.
             *
             * @param mixed $key
             * The key of the element to return.
             * 
             * @return mixed
             * The element with the specified key.
             */
            public function offsetGet($key)
            {
                if ($this->ContainsKey($key))
                {
                    return $this->First(
                        function ($item) use ($key)
                        {
                            return $this->Comparer->Equals($item->Key, $key);
                        })->Value;
                }
                else
                {
                    throw new KeyNotFoundException();
                }
            }

            /**
             * Sets the element with the specified key.
             *
             * @param int $key
             * The key of the element to return.
             * 
             * @param mixed $value
             * The value to set with the specified key.
             * 
             * @return void
             */
            public function offsetSet($key, $value)
            {
                if ($this->ContainsKey($key))
                {
                    $entry = $this->First(
                        function ($item) use ($key)
                        {
                            return $this->Comparer->Equals($item->Key, $key);
                        });
                    $property = new \ReflectionProperty($entry, 'value');
                    $property->setAccessible(true);
                    $property->setValue($entry, $value);
                }
                else
                {
                    throw new KeyNotFoundException();
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
                $this->Remove($index);
            }

            /**
             * Adds the specified key and value to the dictionary.
             *
             * @param mixed $key
             * The key of the element to add.
             * 
             * @param mixed $value
             * The value of the element to add. The value can be **null**.
             * 
             * @return void
             */
            public function Add($key, $value)
            {
                if ($key === null)
                {
                    throw new ArgumentNullException('key');
                }
                else if ($this->ContainsKey($key))
                {
                    throw new ArgumentException('key');
                }
                else
                {
                    $this->InnerList->Add(new KeyValuePair($key, $value));
                }
            }

            /**
             * Removes all keys and values from the Dictionary.
             *
             * @return void
             */
            public function Clear()
            {
                $this->InnerList->Clear();
            }

            /**
             * Determines whether the collection contains a specific key and value.
             *
             * @param KeyValuePair $keyValuePair
             * The KeyValuePair to locate in the collection.
             * 
             * @return bool
             * **true** if _keyValuePair_ is found in the collection; otherwise, **false**.
             */
            public function Contains($keyValuePair)
            {
                return parent::Contains($keyValuePair);
            }

            /**
             * Determines whether the Dictionary contains the specified key.
             *
             * @param mixed $key
             * The key to locate in the Dictionary.
             * 
             * @return bool
             * **true** if the Dictionary contains an element with the specified key; otherwise, **false**.
             */
            public function ContainsKey($key)
            {
                if ($key !== null)
                {
                    return $this->Any(function ($item) use ($key)
                    {
                        return $this->Comparer->Equals($item->Key, $key);
                    });
                }
                else
                {
                    throw new ArgumentNullException('key');
                }
            }

            /**
             * Determines whether the Dictionary contains a specific value.
             *
             * @param mixed $value
             * The value to locate in the Dictionary. The value can be **null**.
             * 
             * @return bool
             * **true** if the Dictionary contains an element with the specified value; otherwise, **false**.
             */
            public function ContainsValue($value)
            {
                return $this->Any(function ($item) use ($value)
                {
                    return EqualityComparer::$Default->Equals($item->Value, $value);
                });
            }

            /**
             * Returns an enumerator that iterates through the Dictionary.
             *
             * @return Enumerator
             * An Enumerator structure for the Dictionary.
             */
            public function GetEnumerator()
            {
                return new Enumerator(function ()
                {
                    for ($enumerator = $this->InnerList->GetEnumerator(); $enumerator->Valid; $enumerator->MoveNext())
                    {
                        yield $enumerator->Current;
                    }
                });
            }

            /**
             * Removes the value with the specified key from the Dictionary.
             *
             * @param mixed $key
             * The key of the element to remove.
             * 
             * @return bool
             * **true** if the element is successfully found and removed; otherwise, **false**. This method returns **false** if key is not found in the Dictionary.
             */
            public function Remove($key)
            {
                if ($key !== null)
                {
                    $index = $this->InnerList->FindIndex(
                        function ($item) use ($key)
                        {
                            return $this->Comparer->Equals($item->Key, $key);
                        });

                    if ($index >= 0)
                    {
                        $this->InnerList->RemoveAt($index);
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    throw new ArgumentNullException('key');
                }
            }

            /**
             * Gets the value associated with the specified key.
             *
             * @param mixed $key
             * The key of the value to get.
             * 
             * @param mixed $value
             * When this method returns, contains the value associated with the specified key, if the key is found; otherwise, **null**. This parameter is passed uninitialized.
             * 
             * @return bool
             * **true** if the Dictionary contains an element with the specified key; otherwise, **false**.
             */
            public function TryGetValue($key, &$value)
            {
                if ($key !== null)
                {
                    if ($this->ContainsKey($key))
                    {
                        $value = $this[$key];
                        return true;
                    }
                    else
                    {
                        $value = null;
                        return false;
                    }
                }
                else
                {
                    throw new ArgumentNullException('key');
                }
            }
        }
    }
?>