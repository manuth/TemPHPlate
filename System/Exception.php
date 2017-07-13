<?php
    namespace System
    {
        class Exception extends Object
        {
            public function getException()
            {
                return new \Exception();
            }
        }
    }
?>