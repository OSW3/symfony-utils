<?php 

return static function($definition)
{
    $definition->rootNode()->children()
    ->append( (include __DIR__."/listeners/minify.php")() )
    ->end();
};