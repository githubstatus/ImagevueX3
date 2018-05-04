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
<header class=header>

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
            echo "\t\t\t\t<img src='";
            echo ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFunction('firstImage')->getCallable(), array("./content/custom/logo")));
            echo "' alt='";
            echo (isset($context["logo_title"]) ? $context["logo_title"] : null);
            echo "' />
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
        echo "\t\t<div class=nav-wrapper>
\t\t\t<nav class=nav>
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
            echo "\" class='logo ";
            echo (isset($context["logo_classes"]) ? $context["logo_classes"] : null);
            echo "'>";
            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["logo_content"]) ? $context["logo_content"] : null)));
            echo "</a>
\t\t\t\t";
        }
        // line 27
        echo "\t\t\t\t</div>
\t\t\t\t<ul class='menu slim'>
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
        return array (  96 => 32,  88 => 29,  69 => 23,  56 => 17,  53 => 15,  44 => 12,  36 => 10,  27 => 6,  343 => 121,  340 => 120,  330 => 114,  327 => 113,  325 => 112,  321 => 111,  317 => 110,  315 => 109,  309 => 105,  306 => 103,  301 => 102,  298 => 101,  295 => 99,  289 => 97,  286 => 96,  283 => 94,  277 => 92,  274 => 91,  270 => 88,  264 => 85,  261 => 83,  252 => 80,  236 => 77,  233 => 75,  217 => 69,  201 => 57,  198 => 55,  192 => 53,  189 => 52,  186 => 50,  173 => 46,  163 => 43,  156 => 42,  147 => 40,  142 => 39,  139 => 37,  132 => 36,  126 => 35,  105 => 30,  102 => 28,  61 => 18,  45 => 12,  22 => 2,  92 => 25,  89 => 36,  85 => 24,  81 => 31,  78 => 23,  74 => 25,  71 => 24,  67 => 23,  55 => 17,  52 => 16,  49 => 14,  40 => 11,  34 => 9,  31 => 8,  29 => 7,  26 => 4,  24 => 5,  21 => 2,  266 => 101,  263 => 99,  260 => 98,  258 => 97,  255 => 81,  251 => 93,  248 => 92,  245 => 91,  241 => 88,  238 => 86,  224 => 85,  221 => 70,  218 => 82,  215 => 81,  212 => 80,  210 => 79,  207 => 78,  204 => 58,  199 => 76,  196 => 74,  193 => 73,  190 => 72,  187 => 71,  184 => 70,  182 => 69,  179 => 48,  176 => 47,  170 => 44,  167 => 63,  164 => 61,  161 => 60,  158 => 58,  155 => 57,  152 => 56,  149 => 41,  146 => 54,  143 => 52,  125 => 51,  122 => 34,  119 => 48,  116 => 32,  113 => 46,  110 => 31,  107 => 44,  104 => 43,  101 => 41,  98 => 40,  95 => 27,  90 => 30,  87 => 37,  84 => 27,  82 => 34,  79 => 32,  77 => 31,  75 => 30,  72 => 28,  68 => 20,  64 => 20,  62 => 21,  59 => 19,  57 => 18,  54 => 17,  50 => 14,  46 => 13,  43 => 12,  41 => 13,  39 => 10,  37 => 9,  35 => 10,  33 => 9,  30 => 8,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
