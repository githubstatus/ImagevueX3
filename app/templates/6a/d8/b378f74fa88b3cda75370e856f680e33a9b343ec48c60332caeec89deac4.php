<?php

/* partials/module.layout.html */
class __TwigTemplate_6ad8b378f74fa88b3cda75370e856f680e33a9b343ec48c60332caeec89deac4 extends Twig_Template
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
";
        // line 3
        $context["name"] = (isset($context["module"]) ? $context["module"] : null);
        // line 4
        $context["module"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), (isset($context["module"]) ? $context["module"] : null), array(), "array");
        // line 5
        echo "
";
        // line 7
        if (($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "width") && ($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "width") != "width-default"))) {
            // line 8
            echo "\t";
            $context["width"] = $this->getAttribute((isset($context["module"]) ? $context["module"] : null), "width");
        } elseif (($this->getAttribute((isset($context["layout"]) ? $context["layout"] : null), "width") && ($this->getAttribute((isset($context["layout"]) ? $context["layout"] : null), "width") != "width-default"))) {
            // line 10
            echo "  ";
            $context["width"] = $this->getAttribute((isset($context["layout"]) ? $context["layout"] : null), "width");
        } else {
            // line 12
            echo "\t";
            $context["width"] = "";
        }
        // line 14
        echo "
";
        // line 16
        if ((((isset($context["width"]) ? $context["width"] : null) == "wide") || ((isset($context["name"]) ? $context["name"] : null) == "disqus"))) {
            // line 17
            echo "\t";
            $context["columns"] = "";
        } elseif (((isset($context["width"]) ? $context["width"] : null) == "narrow")) {
            // line 19
            echo "\t";
            $context["columns"] = "small-12 large-10 small-centered columns";
        } elseif (((isset($context["width"]) ? $context["width"] : null) == "narrower")) {
            // line 21
            echo "\t";
            $context["columns"] = "small-12 medium-10 large-8 small-centered columns";
        } elseif (((isset($context["width"]) ? $context["width"] : null) == "narrowest")) {
            // line 23
            echo "\t";
            $context["columns"] = "small-12 medium-9 large-6 small-centered columns";
        } else {
            // line 25
            echo "\t";
            $context["columns"] = "small-12 small-centered columns";
        }
        // line 27
        echo "
";
        // line 29
        if ((((isset($context["width"]) ? $context["width"] : null) == "wide") || ((isset($context["name"]) ? $context["name"] : null) == "disqus"))) {
            // line 30
            echo "\t<div class=\"module\">
";
        } else {
            // line 32
            echo "\t<div class=\"module row\">
";
        }
        // line 34
        echo "
";
        // line 36
        ob_start();
        // line 37
        if (((isset($context["name"]) ? $context["name"] : null) == "gallery")) {
            echo "itemscope itemtype=\"http://schema.org/ImageGallery\"";
        }
        $context["schema"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 39
        echo "
";
        // line 41
        if ($this->getAttribute($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "caption"), "enabled")) {
            // line 42
            echo "\t";
            $context["caption_classes"] = $this->getAttribute($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "caption"), "align");
            // line 43
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "caption"), "hover")) {
                $context["caption_classes"] = ((isset($context["caption_classes"]) ? $context["caption_classes"] : null) . " caption-hover");
            }
        }
        // line 45
        echo "
";
        // line 47
        if ((($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "layout") == "vertical") && $this->getAttribute($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "vertical"), "horizontal_rule"))) {
            // line 48
            echo "\t";
            $context["hr"] = "hr";
        }
        // line 50
        echo "
";
        // line 56
        echo "
";
        // line 58
        ob_start();
        echo "clearfix ";
        echo (isset($context["name"]) ? $context["name"] : null);
        echo " ";
        echo (isset($context["columns"]) ? $context["columns"] : null);
        echo " ";
        if ($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "layout")) {
            echo "layout-";
            echo $this->getAttribute((isset($context["module"]) ? $context["module"] : null), "layout");
        }
        echo " ";
        echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "include"), "layout");
        echo " ";
        echo $this->getAttribute((isset($context["layout"]) ? $context["layout"] : null), "classes");
        echo " ";
        echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "include"), (isset($context["name"]) ? $context["name"] : null), array(), "array");
        echo " ";
        echo $this->getAttribute((isset($context["module"]) ? $context["module"] : null), "classes");
        echo " ";
        echo (isset($context["caption_classes"]) ? $context["caption_classes"] : null);
        echo " ";
        echo (isset($context["class"]) ? $context["class"] : null);
        echo " title-";
        echo (($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "title_size", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "title_size"), "normal"))) : ("normal"));
        echo " ";
        echo (isset($context["width"]) ? $context["width"] : null);
        echo " ";
        echo (isset($context["hr"]) ? $context["hr"] : null);
        echo " ";
        echo (($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "text_align", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["module"]) ? $context["module"] : null), "text_align"), $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "context"), "text_align")))) : ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "context"), "text_align")));
        $context["module_classes"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 59
        $context["module_classes"] = call_user_func_array($this->env->getFilter('textAlign')->getCallable(), array(call_user_func_array($this->env->getFilter('cleanData')->getCallable(), array((isset($context["module_classes"]) ? $context["module_classes"] : null)))));
        // line 60
        echo "
";
        // line 62
        echo "<div class=\"";
        echo (isset($context["module_classes"]) ? $context["module_classes"] : null);
        echo "\" ";
        echo (isset($context["schema"]) ? $context["schema"] : null);
        echo ">
\t";
        // line 63
        $template = $this->env->resolveTemplate((("partials/module." . (isset($context["name"]) ? $context["name"] : null)) . ".html"));
        $template->display($context);
        // line 64
        echo "\t<hr class=\"module-separator\" />
\t";
        // line 66
        echo "</div>

";
        // line 69
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "partials/module.layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  174 => 69,  157 => 62,  154 => 60,  114 => 50,  86 => 37,  60 => 23,  48 => 17,  51 => 19,  42 => 14,  127 => 51,  124 => 49,  120 => 58,  117 => 56,  106 => 42,  103 => 41,  100 => 39,  93 => 37,  79 => 34,  76 => 32,  58 => 22,  45 => 16,  38 => 13,  90 => 43,  61 => 18,  56 => 21,  44 => 12,  36 => 12,  27 => 6,  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 125,  335 => 124,  331 => 123,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 112,  303 => 110,  300 => 109,  297 => 107,  291 => 105,  288 => 104,  284 => 101,  269 => 94,  266 => 93,  254 => 90,  251 => 88,  243 => 83,  239 => 82,  226 => 71,  223 => 70,  220 => 68,  214 => 66,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 55,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 59,  146 => 46,  142 => 45,  136 => 43,  130 => 52,  115 => 46,  112 => 36,  69 => 28,  65 => 23,  53 => 19,  47 => 16,  32 => 8,  22 => 3,  108 => 47,  105 => 45,  101 => 41,  98 => 34,  95 => 39,  92 => 38,  88 => 29,  85 => 34,  81 => 34,  78 => 27,  74 => 31,  71 => 29,  67 => 24,  55 => 17,  52 => 19,  49 => 18,  40 => 12,  34 => 9,  31 => 8,  29 => 7,  26 => 5,  24 => 4,  21 => 2,  278 => 98,  275 => 96,  272 => 103,  270 => 102,  267 => 100,  263 => 98,  260 => 97,  257 => 96,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 84,  219 => 83,  216 => 82,  211 => 65,  208 => 63,  205 => 78,  202 => 77,  199 => 76,  196 => 75,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 59,  155 => 57,  137 => 54,  134 => 53,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 45,  110 => 48,  107 => 44,  102 => 43,  99 => 43,  96 => 42,  94 => 41,  91 => 39,  89 => 36,  87 => 35,  84 => 36,  80 => 31,  77 => 32,  73 => 30,  70 => 25,  68 => 27,  66 => 26,  64 => 25,  62 => 22,  59 => 21,  57 => 20,  54 => 20,  50 => 14,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 10,  30 => 8,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
