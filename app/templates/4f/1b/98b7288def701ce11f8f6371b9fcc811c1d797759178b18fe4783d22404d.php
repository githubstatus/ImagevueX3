<?php

/* file.json */
class __TwigTemplate_4f1b98b7288def701ce11f8f6371b9fcc811c1d797759178b18fe4783d22404d extends Twig_Template
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
        $this->env->loadTemplate("page.json")->display($context);
    }

    public function getTemplateName()
    {
        return "file.json";
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
