<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Globalization;
    use System\Object;
    {
        /**
         * Represents a culture.
         * 
         * @property-read string $Name
         * Gets the culture name in the format _languagecode2-country_/_regioncode2_.
         */
        class CultureInfo extends Object
        {
            /**
             * The matcher for matching culture-codes.
             * 
             * @var string
             */
            private static $cultureMatcher = '/^([A-Z]*)(?:[-_]([A-Z]*))?(?:[-_]([A-Z]*))?$/';
            
            /**
             * The two-letter language-code.
             * 
             * @var string
             */
            private $languageCode;
        
            /**
             * The charset-code.
             * 
             * @var string
             */
            private $charsetCode;
        
            /**
             * The two-letter region-code.
             * 
             * @var string
             */
            private $regionCode;

            /**
             * Initializes a new instance of the CultureInfo class with a name.
             * 
             * @param string $name
             * The name of the culture.
             */
            public function CultureInfo(string $name)
            {
                $name = strtoupper($name);

                if (preg_match(self::$cultureMatcher, $name, $match) > 0)
                {
                    if ($match != null)
                    {
                        $languageCodeConverter = function (string $languageCode) : string
                        {
                            return strtolower($languageCode);
                        };

                        $charsetCodeConverter = function (string $charsetCode) : string
                        {
                            return '' +
                                strtoupper(substr($charsetCode, 0, 1)) +
                                strtolower(substr($charsetCode, 1));
                        };

                        $regionCodeConverter = function (string $regionCode) : string
                        {
                            return strtoupper($regionCode);
                        };

                        $this->languageCode = $languageCodeConverter($match[1]);

                        if (count($match) > 2)
                        {
                            $regionIndex;

                            if (count($match) > 3)
                            {
                                $this->charsetCode = $charsetCodeConverter($match[2]);
                                $regionIndex = 3;
                            }
                            else
                            {
                                $regionIndex = 2;
                            }

                            $this->regionCode = $regionCodeConverter($match[$regionIndex]);
                        }
                    }
                }
            }

            /**
             * @ignore
             */
            private function getNameParts() : array
            {
                $result = array();
                $result[] = $this->languageCode;

                if ($this->charsetCode != null)
                {
                    $result[] = $this->charsetCode;
                }

                if ($this->regionCode != null)
                {
                    $result[] = $this->regionCode;
                }

                return $result;
            }

            /**
             * @ignore
             */
            private function getLinuxName() : string
            {
                return join('_', $this->NameParts).'.UTF8';
            }

            /**
             * @ignore
             */
            public function getName() : string
            {
                return join('-', $this->NameParts);
            }

            /**
             * Gets the `CultureInfo` object that is culture-independent (invariant).
             *
             * @var self
             */
            public static $InvariantCulture;

            /**
             * The current culture of the php-website.
             * @var CultureInfo
             */
            public static function GetCurrentCulture() : self
            {
                return new self(locale_get_default());
            }

            /**
             * Sets the current culture.
             *
             * @param CultureInfo $cultureInfo
             * The category to assign the culture to.
             */
            public static function SetCurrentCulture(self $cultureInfo)
            {
                if (!setlocale(LC_ALL, $cultureInfo->Name))
                {
                    if (!setlocale(LC_ALL, $cultureInfo->LinuxName))
                    {
                        throw new CultureNotFoundException($cultureInfo->Name);
                    }
                }
            }

            /**
             * @ignore
             */
            public static function __InitializeStatic()
            {
                self::$InvariantCulture = new self('inv');
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public function ToString() : string
            {
                return $this->Name;
            }
        }
    }
?>