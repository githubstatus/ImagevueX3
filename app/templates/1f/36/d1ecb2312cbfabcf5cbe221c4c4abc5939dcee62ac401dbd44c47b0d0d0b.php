<?php

/* partials/nav/article-nav.html */
class __TwigTemplate_1f36d1ecb2312cbfabcf5cbe221c4c4abc5939dcee62ac401dbd44c47b0d0d0b extends Twig_Template
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
        // line 3
        if (((($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "pagenav") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "slug"))))) && (call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "plugins"), "pagenav"), "hide_has_children"))) || ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "children_count") == 0))) && (call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "plugins"), "pagenav"), "hide_root"))) || (call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), "/")))) > 2)))) {
            // line 6
            echo "
";
            // line 8
            $context["siblings"] = call_user_func_array($this->env->getFunction('get_adjacent_siblings')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "file_path")));
            // line 9
            if (((isset($context["siblings"]) ? $context["siblings"] : null) && ($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 0, array(), "array") || $this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 1, array(), "array")))) {
                // line 10
                echo "
";
                // line 12
                $context["href_base"] = call_user_func_array($this->env->getFilter('dirname')->getCallable(), array((isset($context["rootpath_page"]) ? $context["rootpath_page"] : null)));
                // line 13
                if ((call_user_func_array($this->env->getFilter('last')->getCallable(), array($this->env, (isset($context["href_base"]) ? $context["href_base"] : null))) != "/")) {
                    $context["href_base"] = ((isset($context["href_base"]) ? $context["href_base"] : null) . "/");
                }
                // line 14
                echo "
";
                // line 16
                echo "<div class=article-nav>

\t";
                // line 18
                if ($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 1, array(), "array")) {
                    // line 19
                    echo "\t\t<a href='";
                    echo (((isset($context["href_base"]) ? $context["href_base"] : null) . $this->getAttribute($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 1, array(), "array"), "slug")) . "/");
                    echo "' class='next'><span>";
                    echo call_user_func_array($this->env->getFilter('title')->getCallable(), array($this->env, $this->getAttribute($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 1, array(), "array"), "label")));
                    echo "</span></a>
\t";
                }
                // line 21
                echo "
\t";
                // line 22
                if ($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 0, array(), "array")) {
                    // line 23
                    echo "\t\t<a href='";
                    echo (((isset($context["href_base"]) ? $context["href_base"] : null) . $this->getAttribute($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 0, array(), "array"), "slug")) . "/");
                    echo "' class='previous'><span>";
                    echo call_user_func_array($this->env->getFilter('title')->getCallable(), array($this->env, $this->getAttribute($this->getAttribute((isset($context["siblings"]) ? $context["siblings"] : null), 0, array(), "array"), "label")));
                    echo "</span></a>
\t";
                }
                // line 25
                echo "
\t";
                // line 35
                echo "
</div>
";
            }
        }
        // line 39
        echo "
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "partials/nav/article-nav.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 19,  42 => 14,  137 => 55,  134 => 54,  130 => 53,  127 => 52,  124 => 50,  120 => 49,  117 => 48,  115 => 47,  106 => 43,  103 => 42,  100 => 40,  93 => 38,  76 => 33,  66 => 27,  58 => 23,  38 => 13,  96 => 39,  88 => 29,  69 => 29,  56 => 22,  53 => 20,  44 => 12,  36 => 12,  27 => 6,  343 => 121,  340 => 120,  330 => 114,  327 => 113,  325 => 112,  321 => 111,  317 => 110,  315 => 109,  309 => 105,  306 => 103,  301 => 102,  298 => 101,  295 => 99,  289 => 97,  286 => 96,  283 => 94,  277 => 92,  274 => 91,  270 => 88,  264 => 85,  261 => 83,  252 => 80,  236 => 77,  233 => 75,  217 => 69,  201 => 57,  198 => 55,  192 => 53,  189 => 52,  186 => 50,  173 => 46,  163 => 43,  156 => 42,  147 => 40,  142 => 39,  139 => 37,  132 => 36,  126 => 35,  105 => 30,  102 => 28,  61 => 18,  45 => 16,  22 => 2,  92 => 25,  89 => 36,  85 => 24,  81 => 39,  78 => 23,  74 => 32,  71 => 30,  67 => 23,  55 => 17,  52 => 16,  49 => 18,  40 => 13,  34 => 9,  31 => 9,  29 => 8,  26 => 6,  24 => 3,  21 => 2,  266 => 101,  263 => 99,  260 => 98,  258 => 97,  255 => 81,  251 => 93,  248 => 92,  245 => 91,  241 => 88,  238 => 86,  224 => 85,  221 => 70,  218 => 82,  215 => 81,  212 => 80,  210 => 79,  207 => 78,  204 => 58,  199 => 76,  196 => 74,  193 => 73,  190 => 72,  187 => 71,  184 => 70,  182 => 69,  179 => 48,  176 => 47,  170 => 44,  167 => 63,  164 => 61,  161 => 60,  158 => 58,  155 => 57,  152 => 56,  149 => 41,  146 => 54,  143 => 52,  125 => 51,  122 => 34,  119 => 48,  116 => 32,  113 => 46,  110 => 44,  107 => 44,  104 => 43,  101 => 41,  98 => 40,  95 => 27,  90 => 36,  87 => 37,  84 => 27,  82 => 34,  79 => 35,  77 => 31,  75 => 35,  72 => 25,  68 => 20,  64 => 23,  62 => 22,  59 => 21,  57 => 18,  54 => 17,  50 => 14,  46 => 13,  43 => 15,  41 => 13,  39 => 10,  37 => 9,  35 => 10,  33 => 10,  30 => 8,  28 => 7,  25 => 4,  23 => 3,  19 => 1,);
    }
}
