<?php

/* site.json */
class __TwigTemplate_931d1b2c373560769a870d1a4024b98bdbd5839faa1863974d31470079f454a9 extends Twig_Template
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
        ob_start();
        $this->env->loadTemplate("partials/site.json")->display($context);
        $context["data"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        echo "{ ";
        echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["data"]) ? $context["data"] : null))), ","));
        echo " }";
    }

    public function getTemplateName()
    {
        return "site.json";
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
