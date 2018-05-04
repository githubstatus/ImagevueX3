<?php

/* partials/footer.html */
class __TwigTemplate_76bfd9be1a42cb5872013f94b2c2c526c2f5589af4f3adf0516b3657b1687302 extends Twig_Template
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
        echo "</main>
</div>
</div>

<footer class=\"footer\">

\t";
        // line 8
        echo "\t";
        echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('removeComments')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "footer"))), array("{{copy}}" => (((((("<p>&copy; " . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "current_year")) . " <a href=\"") . (isset($context["rootpath"]) ? $context["rootpath"] : null)) . "/\">") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "base_url")) . "</a></p>"))))));
        echo "

\t";
        // line 12
        echo "\t<p class=\"x3-footer-link\">X3 ";
        echo call_user_func_array($this->env->getFunction('random')->getCallable(), array($this->env, array(0 => "Photo Gallery Website", 1 => "Photography Website", 2 => "Image Gallery CMS", 3 => "Website for Photographers", 4 => "Online Portfolio")));
        echo " by <a href=\"https://www.photo.gallery\">www.photo.gallery</a></p>
</footer>

";
        // line 16
        echo "<script>
var x3_settings = ";
        // line 17
        echo call_user_func_array($this->env->getFunction('jsonSettings')->getCallable(), array((isset($context["page"]) ? $context["page"] : null)));
        echo ";
var x3_page = ";
        // line 18
        echo call_user_func_array($this->env->getFunction('pageJson')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null), (isset($context["page_description"]) ? $context["page_description"] : null), "", $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "template_name"), $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "id"), (isset($context["preview_image_full"]) ? $context["preview_image_full"] : null), $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "file_path")));
        echo ";
";
        // line 19
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 20
            echo "function jsFail(){
\tvar s = document.createElement('script');
\ts.type = 'text/javascript';
\ts.onload = imagevue_;
\ts.src = '";
            // line 24
            echo (isset($context["rootpath"]) ? $context["rootpath"] : null);
            echo "/app/public/js/";
            echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version");
            echo "/x3.min.js';
\tdocument.getElementsByTagName('head')[0].appendChild(s);
}
";
        }
        // line 28
        echo "</script>

";
        // line 31
        $context["custom_js_files"] = call_user_func_array($this->env->getFunction('x3_glob')->getCallable(), array("./content/custom/files/javascript/*include*.js", (("<script id=\"custom_javascript_{{index}}\" src=\"" . (isset($context["assetspath"]) ? $context["assetspath"] : null)) . "/content/custom/files/javascript/{{basename}}\"></script>")));
        // line 32
        if ((isset($context["custom_js_files"]) ? $context["custom_js_files"] : null)) {
            echo (isset($context["custom_js_files"]) ? $context["custom_js_files"] : null);
        }
        // line 33
        echo "
";
        // line 35
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "js"))))))) {
            // line 36
            echo "<script id=\"custom-javascript\">";
            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "js")));
            echo "</script>
";
        }
        // line 38
        echo "
";
        // line 40
        echo "<script src=\"";
        echo (isset($context["cdn_core"]) ? $context["cdn_core"] : null);
        echo "/js/";
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version");
        echo "/x3.min.js\" async";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo " onerror=\"jsFail()\"";
        }
        echo " onload=\"imagevue";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo "_";
        }
        echo "();\"></script>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "partials/footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  860 => 313,  855 => 312,  853 => 311,  848 => 308,  829 => 303,  823 => 301,  820 => 300,  814 => 298,  808 => 296,  805 => 295,  802 => 294,  799 => 292,  793 => 289,  790 => 288,  786 => 286,  783 => 285,  771 => 279,  765 => 277,  762 => 276,  759 => 274,  753 => 273,  747 => 271,  741 => 269,  729 => 265,  726 => 264,  721 => 263,  718 => 262,  712 => 258,  702 => 255,  700 => 245,  697 => 243,  691 => 242,  685 => 240,  679 => 238,  673 => 236,  670 => 235,  657 => 233,  651 => 230,  648 => 229,  645 => 228,  642 => 227,  639 => 226,  636 => 224,  633 => 223,  630 => 221,  610 => 214,  605 => 213,  602 => 212,  570 => 209,  567 => 207,  560 => 203,  557 => 202,  554 => 201,  551 => 200,  548 => 199,  523 => 192,  520 => 191,  517 => 190,  514 => 189,  511 => 188,  508 => 187,  505 => 186,  502 => 185,  497 => 182,  494 => 181,  491 => 180,  488 => 178,  485 => 177,  481 => 175,  477 => 173,  471 => 171,  468 => 170,  465 => 168,  462 => 167,  459 => 166,  453 => 165,  443 => 163,  435 => 162,  413 => 153,  403 => 150,  400 => 149,  397 => 147,  394 => 146,  385 => 145,  382 => 144,  379 => 143,  368 => 141,  355 => 139,  350 => 138,  347 => 137,  344 => 136,  341 => 135,  338 => 133,  335 => 132,  332 => 130,  329 => 129,  326 => 128,  323 => 127,  320 => 126,  314 => 124,  311 => 123,  308 => 122,  305 => 121,  302 => 119,  299 => 118,  296 => 117,  293 => 116,  290 => 115,  287 => 114,  272 => 108,  197 => 77,  194 => 76,  191 => 74,  188 => 73,  185 => 72,  140 => 57,  32 => 9,  947 => 292,  933 => 291,  928 => 289,  925 => 288,  921 => 286,  918 => 285,  912 => 280,  906 => 278,  903 => 277,  900 => 275,  894 => 274,  891 => 273,  886 => 272,  881 => 271,  876 => 270,  871 => 269,  866 => 268,  859 => 267,  854 => 266,  851 => 265,  845 => 306,  839 => 260,  836 => 259,  830 => 258,  827 => 257,  822 => 256,  817 => 255,  812 => 254,  807 => 253,  800 => 252,  796 => 251,  787 => 250,  784 => 248,  781 => 247,  778 => 282,  775 => 281,  772 => 244,  769 => 243,  766 => 241,  763 => 240,  758 => 237,  743 => 236,  740 => 234,  735 => 267,  732 => 230,  725 => 229,  722 => 228,  716 => 227,  711 => 226,  706 => 257,  698 => 224,  690 => 223,  684 => 222,  676 => 221,  671 => 220,  668 => 219,  666 => 234,  658 => 215,  654 => 231,  650 => 213,  647 => 212,  644 => 211,  641 => 210,  635 => 208,  632 => 207,  629 => 206,  626 => 219,  618 => 217,  615 => 202,  612 => 215,  609 => 200,  601 => 198,  598 => 197,  595 => 196,  589 => 194,  586 => 193,  578 => 191,  575 => 190,  565 => 206,  562 => 187,  559 => 185,  556 => 184,  553 => 183,  550 => 182,  547 => 181,  544 => 180,  541 => 198,  538 => 197,  535 => 177,  532 => 196,  529 => 195,  526 => 194,  521 => 171,  518 => 169,  513 => 168,  510 => 166,  476 => 165,  473 => 163,  470 => 162,  467 => 161,  464 => 160,  461 => 159,  458 => 158,  455 => 157,  451 => 155,  448 => 164,  445 => 153,  442 => 152,  439 => 150,  436 => 149,  433 => 148,  430 => 161,  427 => 160,  424 => 158,  421 => 157,  418 => 143,  415 => 142,  412 => 141,  409 => 152,  406 => 151,  404 => 138,  401 => 137,  398 => 136,  396 => 135,  393 => 134,  390 => 133,  387 => 131,  384 => 130,  378 => 128,  372 => 125,  369 => 124,  366 => 123,  363 => 140,  357 => 120,  354 => 118,  351 => 117,  348 => 116,  345 => 115,  342 => 114,  339 => 113,  336 => 112,  333 => 111,  324 => 107,  312 => 105,  276 => 98,  262 => 96,  242 => 96,  239 => 94,  230 => 90,  209 => 81,  206 => 80,  203 => 79,  200 => 78,  195 => 71,  183 => 67,  180 => 66,  177 => 65,  171 => 63,  168 => 62,  165 => 63,  162 => 61,  159 => 58,  150 => 54,  123 => 50,  118 => 45,  97 => 36,  381 => 129,  375 => 126,  373 => 142,  370 => 145,  367 => 143,  360 => 121,  356 => 136,  349 => 134,  337 => 129,  331 => 127,  328 => 126,  319 => 122,  316 => 121,  313 => 119,  303 => 103,  300 => 116,  297 => 101,  294 => 113,  284 => 113,  281 => 112,  278 => 111,  275 => 109,  269 => 107,  257 => 102,  254 => 101,  246 => 96,  243 => 94,  240 => 93,  227 => 89,  223 => 84,  208 => 82,  205 => 81,  202 => 79,  181 => 72,  178 => 70,  175 => 69,  172 => 67,  169 => 66,  166 => 65,  160 => 62,  148 => 57,  145 => 60,  136 => 52,  133 => 53,  111 => 41,  83 => 36,  80 => 33,  47 => 18,  174 => 64,  157 => 61,  154 => 59,  114 => 45,  108 => 40,  99 => 43,  94 => 35,  91 => 34,  86 => 35,  73 => 30,  60 => 23,  48 => 17,  51 => 19,  42 => 13,  137 => 55,  134 => 54,  130 => 52,  127 => 51,  124 => 50,  120 => 47,  117 => 46,  115 => 43,  106 => 43,  103 => 38,  100 => 37,  93 => 39,  76 => 29,  66 => 27,  58 => 23,  38 => 11,  96 => 42,  88 => 33,  69 => 29,  56 => 20,  53 => 20,  44 => 14,  36 => 11,  27 => 8,  343 => 132,  340 => 131,  330 => 110,  327 => 108,  325 => 124,  321 => 111,  317 => 125,  315 => 106,  309 => 104,  306 => 103,  301 => 102,  298 => 101,  295 => 99,  289 => 100,  286 => 96,  283 => 94,  277 => 92,  274 => 91,  270 => 97,  264 => 85,  261 => 83,  252 => 80,  236 => 93,  233 => 92,  217 => 69,  201 => 57,  198 => 72,  192 => 70,  189 => 69,  186 => 68,  173 => 67,  163 => 64,  156 => 57,  147 => 53,  142 => 54,  139 => 37,  132 => 36,  126 => 35,  105 => 39,  102 => 28,  61 => 24,  45 => 16,  22 => 3,  92 => 40,  89 => 38,  85 => 32,  81 => 35,  78 => 33,  74 => 32,  71 => 29,  67 => 23,  55 => 18,  52 => 17,  49 => 16,  40 => 16,  34 => 10,  31 => 8,  29 => 7,  26 => 6,  24 => 4,  21 => 2,  266 => 105,  263 => 104,  260 => 103,  258 => 97,  255 => 81,  251 => 99,  248 => 98,  245 => 97,  241 => 88,  238 => 86,  224 => 88,  221 => 86,  218 => 85,  215 => 84,  212 => 82,  210 => 79,  207 => 78,  204 => 58,  199 => 78,  196 => 77,  193 => 76,  190 => 75,  187 => 74,  184 => 73,  182 => 70,  179 => 69,  176 => 68,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 58,  155 => 57,  152 => 59,  149 => 41,  146 => 54,  143 => 52,  125 => 50,  122 => 49,  119 => 48,  116 => 47,  113 => 46,  110 => 45,  107 => 44,  104 => 43,  101 => 42,  98 => 41,  95 => 40,  90 => 37,  87 => 37,  84 => 36,  82 => 31,  79 => 30,  77 => 32,  75 => 31,  72 => 31,  68 => 28,  64 => 25,  62 => 24,  59 => 24,  57 => 21,  54 => 19,  50 => 17,  46 => 15,  43 => 17,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 12,  30 => 8,  28 => 7,  25 => 5,  23 => 3,  19 => 1,);
    }
}
