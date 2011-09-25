<?php 
class TypographusComponent extends Object
{
    function startup(&$controller)
    {
        $this->controller = $controller;
    }

    function process($str)
    {
        App::import('Vendor', 'typographus');
        $typo = new Typographus('UTF-8');
		return $typo->process($str);
    }
}