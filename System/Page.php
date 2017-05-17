<?php
    namespace System;
    {
        class Page extends Object
        {
            public $Name;

            public function Page()
            {
                $this->This("Test");
                echo "Page's Constructor has been called.";
            }

            public function Page1($name)
            {
                $this->Base();
                $this->Name = $name;
            }
        }
    }
?>