<?php

/* video.html */
class __TwigTemplate_7f932cdf0457c8ed9763122a4bfa6c9972010014a0c1ee5a450678cb36b8ee5f extends Twig_Template
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
        $this->env->loadTemplate("partials/module.video.html")->display($context);
        // line 2
        $this->env->loadTemplate("partials/module.disqus.html")->display($context);
    }

    public function getTemplateName()
    {
        return "video.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 2,  19 => 1,);
    }
}
