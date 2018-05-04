<?php

/* sitemap.xml */
class __TwigTemplate_7469f4cff696e13121ae3b012e9bb1184bdbdf62dfe54a7cd839682d1ffb754a extends Twig_Template
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
        // line 2
        echo "
";
        // line 5
        $context["baseurl"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "base_url");
        // line 6
        echo "
";
        // line 8
        $context["absolutepath"] = call_user_func_array($this->env->getFilter('addprotocol')->getCallable(), array((isset($context["baseurl"]) ? $context["baseurl"] : null)));
        // line 9
        $context["rootpath"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["baseurl"]) ? $context["baseurl"] : null), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name") => "")));
        // line 10
        $context["absolutepath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
        // line 11
        $context["rootpath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        // line 12
        echo "
<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<?xml-stylesheet type=\"text/xsl\" href=\"";
        // line 14
        echo (isset($context["rootpath"]) ? $context["rootpath"] : null);
        echo "/app/public/xsl/xml-sitemap.xsl\" ?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">
";
        // line 16
        $this->env->loadTemplate("partials/sitemap/sitemap-url.xml")->display($context);
        // line 17
        echo "</urlset>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "sitemap.xml";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 17,  46 => 16,  41 => 14,  37 => 12,  35 => 11,  33 => 10,  31 => 9,  29 => 8,  26 => 6,  24 => 5,  21 => 2,  19 => 1,);
    }
}
