<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    global $documentType, $arrayList, $enumerable, $iterable, $array, $int;

    $documentTypeNamespace = 'System\Web';
    $documentTypeName = 'DocumentType';
    $documentTypeFullname = $documentTypeNamespace.'\\'.$documentTypeName;
    $arrayListNamespace = 'System\Collections';
    $arrayListName = 'ArrayList';
    $arrayListFullname = $arrayListNamespace.'\\'.$arrayListName;
    $enumerableNamespace = 'System\Collections';
    $enumerableName = 'Enumerable';
    $enumerableFullname = $enumerableNamespace.'\\'.$enumerableName;
    $iterableName = 'iterable';
    $arrayName = 'array';
    $intName = 'int';

    echo '
        <h2>Testing <code>Type</code>-class</h2>';

    RunTest('$documentType = System\Type::GetByName("'.$documentTypeFullname.'")');
    RunTest('$arrayList = System\Type::GetByName("'.$arrayListFullname.'")');
    RunTest('$enumerable = System\Type::GetByName("'.$enumerableFullname.'")');
    RunTest('$array = System\Type::GetByName("'.$arrayName.'")');
    RunTest('$iterable = System\Type::GetByName("'.$iterableName.'")');
    RunTest('$int = System\Type::GetByName("'.$intName.'")');
    RunTest('$documentType->BaseType->Name', 'Enum');
    RunTest('$iterable->BaseType', null);
    RunTest('$int->BaseType', null);
    RunTest('$documentType->FullName', $documentTypeFullname);
    RunTest('$arrayList->FullName', $arrayListFullname);
    RunTest('$iterable->FullName', $iterableName);
    RunTest('$int->FullName', $intName);
    RunTest('$documentType->IsAbstract', false);
    RunTest('$arrayList->IsAbstract', false);
    RunTest('$enumerable->IsAbstract', true);
    RunTest('$iterable->IsAbstract', false);
    RunTest('$array->IsAbstract', false);
    RunTest('$int->IsAbstract', false);
    RunTest('$documentType->IsArray', false);
    RunTest('$arrayList->IsArray', false);
    RunTest('$enumerable->IsArray', false);
    RunTest('$iterable->IsArray', false);
    RunTest('$array->IsArray', true);
    RunTest('$int->IsArray', false);
    RunTest('$documentType->IsClass', false);
    RunTest('$arrayList->IsClass', true);
    RunTest('$iterable->IsClass', false);
    RunTest('$int->IsClass', false);
    RunTest('$documentType->BaseType->IsEnum', false);
    RunTest('$documentType->IsEnum', true);
    RunTest('$arrayList->IsEnum', false);
    RunTest('$iterable->IsEnum', false);
    RunTest('$int->IsEnum', false);
    RunTest('$documentType->IsInterface', false);
    RunTest('$arrayList->IsInterface', false);
    RunTest('$enumerable->IsInterface', false);
    RunTest('$iterable->IsInterface', true);
    RunTest('$array->IsInterface', false);
    RunTest('$int->IsInterface', false);
    RunTest('$documentType->IsValueType', false);
    RunTest('$arrayList->IsValueType', false);
    RunTest('$enumerable->IsValueType', false);
    RunTest('$iterable->IsValueType', false);
    RunTest('$array->IsValueType', true);
    RunTest('$int->IsValueType', true);
    RunTest('$documentType->Name', $documentTypeName);
    RunTest('$arrayList->Name', $arrayListName);
    RunTest('$enumerable->Name', $enumerableName);
    RunTest('$iterable->Name', $iterableName);
    RunTest('$array->Name', $arrayName);
    RunTest('$int->Name', $intName);
    RunTest('$documentType->Namespace', $documentTypeNamespace);
    RunTest('$arrayList->Namespace', $arrayListNamespace);
    RunTest('$enumerable->Namespace', $enumerableNamespace);
    RunTest('$iterable->Namespace', null);
    RunTest('$array->Namespace', null);
    RunTest('$int->Namespace', null);
    RunTest('$arrayList->GetConstructor(array())->getReflectionMethod()->name', 'ArrayList');
    RunTest('$arrayList->GetConstructor(array($array))->getReflectionMethod()->name', 'ArrayList1');
    RunTest('count($arrayList->GetConstructors())', 2);
    RunTest('$arrayList->GetInterface("\ArrayAccess")->Name', 'ArrayAccess');
    RunTest('$arrayList->IsAssignableFrom($arrayList)', true);
    RunTest('$enumerable->IsAssignableFrom($arrayList)', true);
    RunTest('$arrayList->IsAssignableFrom($enumerable)', false);
    RunTest('$iterable->IsAssignableFrom($arrayList)', true);
    RunTest('$arrayList->IsSubclassOf($arrayList)', false);
    RunTest('$enumerable->IsSubclassOf($arrayList)', false);
    RunTest('$arrayList->IsSubclassOf($enumerable)', true);
?>