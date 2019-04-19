<?php

/* file.html */
class __TwigTemplate_1663a4e388acb7b52561c30d23f0ed9ed7115e5eeb372600d419476e4953f4e6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->env->loadTemplate("page.html")->display($context);
    }

    public function getTemplateName()
    {
        return "file.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
