---
Template: BootstrapTemplate
Title: Unit-Tests
---
<h1><?=$this->Title?></h1>
<?php
    $mainTime = microtime(true);
    $globals = $GLOBALS;
    $GLOBALS = array();
    include join(DIRECTORY_SEPARATOR, array('..', 'UnitTests', 'index.php'));
    $GLOBALS = $globals;
    var_dump(microtime(true) - $mainTime);
?>