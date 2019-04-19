<?php

/* partials/nav/header.html */
class __TwigTemplate_bd8ee613027334a20b8eb96b1844a765626cad4d28ba598d0fa3e5133f53d8a5 extends Twig_Template
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
        echo "
<header class=\"header\">

\t\t";
        // line 5
        echo "\t\t";
        $context["logo_title"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "logo", array(), "any", false, true), "title", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "logo", array(), "any", false, true), "title"), "Logo Here"))) : ("Logo Here"));
        // line 6
        echo "
\t\t";
        // line 8
        echo "\t\t";
        ob_start();
        // line 9
        echo "\t\t\t";
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "use_image")) {
            // line 10
            echo "\t\t\t\t<img src=\"";
            echo ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFunction('firstImage')->getCallable(), array("./content/custom/logo")));
            echo "\" alt=\"";
            echo (isset($context["logo_title"]) ? $context["logo_title"] : null);
            echo "\" />
\t\t\t";
        } else {
            // line 12
            echo "\t\t\t\t";
            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["logo_title"]) ? $context["logo_title"] : null)));
            echo "
\t  \t";
        }
        // line 14
        echo "  \t";
        $context["logo_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 15
        echo "
  \t";
        // line 17
        echo "  \t";
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "use_image")) {
            $context["logo_classes"] = " logo-image";
        }
        // line 18
        echo "
\t\t";
        // line 20
        echo "\t\t<div class=\"nav-wrapper\">
\t\t\t<nav class=\"nav\">
\t\t\t\t<div class=\"logo-wrapper\">
\t\t\t\t";
        // line 23
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "enabled")) {
            // line 24
            echo "\t\t\t\t\t";
            $context["logo_link"] = ((call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "link")))) ? (((isset($context["rootpath"]) ? $context["rootpath"] : null) . "/")) : ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "link")));
            // line 25
            echo "\t\t\t\t\t<a href=\"";
            echo (isset($context["logo_link"]) ? $context["logo_link"] : null);
            echo "\" class=\"logo ";
            echo (isset($context["logo_classes"]) ? $context["logo_classes"] : null);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["logo_content"]) ? $context["logo_content"] : null)));
            echo "</a>
\t\t\t\t";
        }
        // line 27
        echo "\t\t\t\t</div>
\t\t\t\t<ul class=\"menu slim\">
\t\t\t\t\t";
        // line 29
        if ((!$this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "menu_disabled"))) {
            // line 30
            echo "\t\t\t\t\t\t";
            echo call_user_func_array($this->env->getFunction('getMenu')->getCallable(), array());
            echo "
\t\t\t\t\t";
        }
        // line 32
        echo "\t\t\t\t</ul>
\t\t\t</nav>
\t\t</div>

</header>";
    }

    public function getTemplateName()
    {
        return "partials/nav/header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 30,  61 => 18,  56 => 17,  44 => 12,  36 => 10,  27 => 6,  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 125,  335 => 124,  331 => 123,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 112,  303 => 110,  300 => 109,  297 => 107,  291 => 105,  288 => 104,  284 => 101,  269 => 94,  266 => 93,  254 => 90,  251 => 88,  243 => 83,  239 => 82,  226 => 71,  223 => 70,  220 => 68,  214 => 66,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 55,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 47,  146 => 46,  142 => 45,  136 => 43,  130 => 42,  115 => 38,  112 => 36,  69 => 23,  65 => 23,  53 => 15,  47 => 16,  32 => 8,  22 => 2,  108 => 45,  105 => 35,  101 => 41,  98 => 34,  95 => 39,  92 => 38,  88 => 29,  85 => 34,  81 => 30,  78 => 30,  74 => 25,  71 => 24,  67 => 23,  55 => 17,  52 => 16,  49 => 15,  40 => 11,  34 => 9,  31 => 8,  29 => 7,  26 => 4,  24 => 5,  21 => 2,  278 => 98,  275 => 96,  272 => 103,  270 => 102,  267 => 100,  263 => 98,  260 => 97,  257 => 96,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 84,  219 => 83,  216 => 82,  211 => 65,  208 => 63,  205 => 78,  202 => 77,  199 => 76,  196 => 75,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 63,  167 => 62,  164 => 61,  161 => 60,  158 => 59,  155 => 57,  137 => 56,  134 => 54,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 46,  110 => 45,  107 => 44,  102 => 43,  99 => 42,  96 => 32,  94 => 39,  91 => 33,  89 => 36,  87 => 35,  84 => 27,  80 => 31,  77 => 29,  73 => 28,  70 => 27,  68 => 26,  66 => 25,  64 => 20,  62 => 21,  59 => 21,  57 => 20,  54 => 18,  50 => 14,  46 => 13,  43 => 12,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
