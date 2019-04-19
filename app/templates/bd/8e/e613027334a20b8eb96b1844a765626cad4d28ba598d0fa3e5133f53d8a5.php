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
        return array (  96 => 32,  84 => 27,  61 => 18,  56 => 17,  44 => 12,  36 => 10,  27 => 6,  359 => 135,  356 => 134,  346 => 128,  343 => 127,  341 => 126,  337 => 125,  333 => 124,  331 => 123,  325 => 119,  322 => 117,  317 => 116,  314 => 115,  311 => 113,  305 => 111,  302 => 110,  299 => 108,  293 => 106,  290 => 105,  286 => 102,  280 => 99,  277 => 97,  271 => 95,  268 => 94,  265 => 92,  254 => 90,  251 => 88,  243 => 83,  226 => 71,  223 => 70,  220 => 68,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  178 => 55,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 47,  146 => 46,  142 => 45,  136 => 43,  130 => 42,  115 => 38,  112 => 36,  91 => 33,  77 => 29,  69 => 23,  65 => 23,  53 => 15,  47 => 16,  32 => 8,  22 => 2,  101 => 41,  98 => 34,  92 => 38,  88 => 29,  85 => 34,  78 => 30,  74 => 25,  71 => 24,  67 => 23,  55 => 17,  52 => 16,  49 => 15,  40 => 11,  34 => 9,  31 => 8,  29 => 7,  26 => 4,  24 => 5,  21 => 2,  284 => 109,  281 => 107,  278 => 106,  276 => 105,  273 => 103,  269 => 101,  266 => 100,  263 => 99,  259 => 96,  256 => 94,  242 => 93,  239 => 82,  236 => 90,  233 => 89,  230 => 88,  228 => 87,  225 => 86,  222 => 85,  217 => 84,  214 => 66,  211 => 65,  208 => 63,  205 => 79,  202 => 78,  200 => 77,  197 => 76,  194 => 75,  188 => 72,  185 => 56,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 64,  167 => 63,  164 => 62,  161 => 60,  143 => 59,  140 => 57,  137 => 56,  134 => 55,  131 => 54,  128 => 53,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 47,  108 => 45,  105 => 35,  102 => 43,  100 => 42,  97 => 40,  95 => 39,  93 => 38,  90 => 30,  86 => 34,  83 => 33,  81 => 30,  79 => 31,  76 => 29,  73 => 28,  70 => 27,  68 => 26,  66 => 25,  64 => 20,  62 => 21,  59 => 21,  57 => 20,  54 => 18,  50 => 14,  46 => 13,  43 => 12,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
