<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\_Type;
    {
        /**
         * Selects a member from a list of candidates, and performs type conversion from actual argument type to formal argument type.
         */
        abstract class _Binder
        {
            /**
             * Selects a method from the given set of methods, based on the argument type.
             *
             * @param int $bindingAttr
             * A bitwise combination of `_BindingFlags` values.
             * 
             * @param \ReflectionMethod[] $match
             * The set of methods that are candidates for matching.
             * For example, when a `Binder` object is used by Type.GetMethod,
             * this parameter specifies the set of methods that reflection has determined to be possible matches,
             * typically because they have the correct member name. 
             * 
             * @param _Type[] $types
             * The parameter types used to locate a matching method.
             * 
             * @return \ReflectionMethod
             * The matching method, if found; otherwise, **null**.
             */
            public abstract function SelectMethod(int $bindingAttr, array $match, array $types = null) : ?\ReflectionMethod;
        }
    }
?>