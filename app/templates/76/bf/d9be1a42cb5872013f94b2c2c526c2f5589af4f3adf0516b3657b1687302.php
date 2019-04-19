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
            echo (isset($context["local_js"]) ? $context["local_js"] : null);
            echo "';
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
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 41
            echo "<script src=\"https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/velocity-animate@1.0.1/velocity.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/velocity-animate@1.0.1/velocity.ui.min.js\"></script>
";
            // line 44
            if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "gallery"), "layout") == "slideshow")) {
                echo "<script src=\"https://cdn.jsdelivr.net/npm/fotorama@4.6.4/fotorama.js\"></script>";
            }
            // line 45
            echo "<script src=\"https://cdn.jsdelivr.net/npm/string@3.3.3/dist/string.min.js\"></script>
";
        } else {
            // line 47
            echo "<script src=\"";
            echo (isset($context["local_public"]) ? $context["local_public"] : null);
            echo "/vendor/jquery/3.3.1/jquery.min.js\"></script>
<script src=\"";
            // line 48
            echo (isset($context["local_public"]) ? $context["local_public"] : null);
            echo "/vendor/velocity/1.0.1/velocity.min.js\"></script>
<script src=\"";
            // line 49
            echo (isset($context["local_public"]) ? $context["local_public"] : null);
            echo "/vendor/velocity/1.0.1/velocity.ui.min.js\"></script>
";
            // line 50
            if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "gallery"), "layout") == "slideshow")) {
                echo "<script src=\"";
                echo (isset($context["local_public"]) ? $context["local_public"] : null);
                echo "/vendor/fotorama/4.6.4/fotorama.js\"></script>";
            }
            // line 51
            echo "<script src=\"";
            echo (isset($context["local_public"]) ? $context["local_public"] : null);
            echo "/vendor/stringjs/3.3.3/string.min.js\"></script>
";
        }
        // line 53
        echo "
";
        // line 55
        echo "<script src=\"";
        echo (isset($context["core_js"]) ? $context["core_js"] : null);
        echo "\"";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo " onerror=\"jsFail()\"";
        }
        echo " onload=\"imagevue";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo "_";
        }
        echo "();\"></script>
";
        // line 57
        echo "
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
        return array (  72 => 32,  1008 => 363,  1003 => 362,  1001 => 361,  996 => 358,  993 => 356,  977 => 353,  971 => 351,  968 => 350,  962 => 348,  956 => 346,  947 => 342,  941 => 339,  934 => 336,  931 => 335,  919 => 329,  910 => 326,  907 => 324,  901 => 323,  895 => 321,  889 => 319,  863 => 311,  860 => 310,  848 => 305,  842 => 293,  833 => 290,  827 => 288,  821 => 286,  815 => 284,  809 => 282,  806 => 281,  796 => 279,  787 => 277,  784 => 275,  781 => 274,  778 => 273,  769 => 270,  766 => 268,  763 => 267,  760 => 265,  756 => 263,  742 => 259,  740 => 258,  735 => 257,  732 => 256,  697 => 253,  694 => 251,  691 => 250,  683 => 248,  680 => 247,  677 => 245,  674 => 244,  671 => 242,  668 => 241,  665 => 240,  662 => 239,  659 => 238,  656 => 237,  653 => 236,  645 => 232,  642 => 231,  639 => 230,  636 => 228,  629 => 225,  625 => 223,  619 => 221,  616 => 220,  613 => 218,  601 => 215,  596 => 214,  590 => 213,  577 => 211,  572 => 210,  569 => 209,  566 => 207,  563 => 206,  555 => 202,  551 => 201,  548 => 200,  539 => 196,  536 => 195,  527 => 194,  524 => 193,  521 => 192,  515 => 191,  510 => 190,  505 => 189,  492 => 187,  489 => 186,  486 => 185,  483 => 184,  480 => 182,  477 => 181,  474 => 179,  471 => 178,  468 => 177,  465 => 176,  462 => 175,  459 => 174,  456 => 173,  453 => 172,  450 => 171,  447 => 170,  444 => 168,  441 => 167,  438 => 166,  433 => 165,  430 => 164,  427 => 163,  424 => 162,  421 => 161,  418 => 160,  415 => 159,  412 => 157,  409 => 156,  404 => 155,  401 => 154,  398 => 152,  395 => 151,  392 => 150,  324 => 130,  321 => 128,  309 => 123,  291 => 116,  288 => 114,  285 => 113,  282 => 112,  270 => 107,  267 => 105,  264 => 104,  261 => 103,  258 => 101,  255 => 100,  252 => 99,  249 => 97,  237 => 93,  234 => 92,  231 => 91,  219 => 85,  216 => 84,  213 => 83,  210 => 82,  207 => 80,  139 => 56,  135 => 54,  132 => 53,  129 => 52,  121 => 49,  109 => 45,  75 => 31,  979 => 304,  965 => 303,  960 => 301,  957 => 300,  953 => 345,  950 => 344,  944 => 292,  938 => 338,  935 => 289,  932 => 287,  926 => 332,  923 => 331,  918 => 284,  913 => 327,  908 => 282,  903 => 281,  898 => 280,  891 => 279,  886 => 278,  883 => 317,  877 => 315,  871 => 313,  868 => 312,  862 => 270,  859 => 269,  854 => 306,  849 => 267,  844 => 303,  839 => 291,  832 => 264,  828 => 263,  819 => 262,  816 => 260,  813 => 259,  810 => 258,  807 => 257,  804 => 256,  801 => 280,  798 => 253,  795 => 252,  790 => 249,  775 => 272,  772 => 271,  767 => 243,  764 => 242,  757 => 241,  754 => 240,  748 => 261,  743 => 238,  738 => 237,  730 => 236,  722 => 235,  716 => 234,  708 => 233,  703 => 232,  700 => 231,  698 => 230,  690 => 227,  686 => 249,  682 => 225,  679 => 224,  676 => 223,  673 => 222,  667 => 220,  664 => 219,  661 => 218,  658 => 217,  650 => 235,  647 => 214,  644 => 213,  641 => 212,  633 => 227,  630 => 209,  627 => 208,  621 => 206,  618 => 205,  610 => 217,  607 => 216,  597 => 200,  594 => 199,  591 => 197,  588 => 196,  585 => 212,  582 => 194,  579 => 193,  576 => 192,  573 => 191,  570 => 190,  567 => 189,  564 => 187,  561 => 186,  558 => 184,  553 => 183,  550 => 181,  545 => 199,  542 => 198,  506 => 177,  503 => 175,  500 => 174,  497 => 188,  494 => 172,  491 => 171,  488 => 170,  485 => 169,  481 => 167,  478 => 166,  475 => 165,  472 => 164,  469 => 162,  466 => 161,  463 => 160,  460 => 159,  457 => 158,  454 => 157,  451 => 156,  448 => 155,  445 => 154,  442 => 153,  439 => 152,  436 => 151,  434 => 150,  431 => 149,  428 => 148,  426 => 147,  423 => 146,  420 => 145,  417 => 143,  414 => 142,  411 => 141,  408 => 140,  405 => 138,  402 => 137,  399 => 136,  396 => 135,  393 => 134,  390 => 133,  387 => 149,  384 => 148,  378 => 146,  372 => 144,  369 => 143,  366 => 142,  363 => 141,  357 => 138,  354 => 137,  351 => 136,  348 => 114,  345 => 113,  342 => 112,  339 => 134,  336 => 133,  330 => 132,  327 => 131,  318 => 127,  315 => 125,  312 => 124,  306 => 122,  292 => 99,  279 => 111,  260 => 94,  248 => 89,  245 => 88,  224 => 80,  221 => 79,  218 => 78,  215 => 77,  212 => 75,  209 => 74,  206 => 73,  203 => 72,  189 => 67,  186 => 66,  183 => 65,  180 => 64,  177 => 63,  165 => 58,  156 => 55,  150 => 52,  147 => 61,  123 => 48,  118 => 50,  82 => 34,  381 => 147,  375 => 145,  373 => 146,  370 => 145,  367 => 143,  360 => 140,  349 => 134,  340 => 131,  328 => 126,  319 => 122,  316 => 121,  313 => 119,  303 => 120,  300 => 119,  297 => 118,  294 => 117,  275 => 107,  257 => 93,  246 => 96,  240 => 94,  227 => 81,  199 => 77,  196 => 76,  193 => 74,  190 => 73,  187 => 72,  184 => 71,  181 => 70,  175 => 68,  172 => 67,  169 => 65,  166 => 65,  163 => 64,  160 => 62,  148 => 57,  145 => 56,  133 => 55,  111 => 41,  80 => 32,  174 => 62,  157 => 61,  154 => 59,  114 => 49,  99 => 43,  94 => 35,  60 => 23,  48 => 16,  87 => 38,  51 => 19,  42 => 13,  127 => 51,  124 => 51,  120 => 46,  117 => 46,  110 => 48,  106 => 44,  103 => 43,  58 => 22,  45 => 15,  38 => 11,  96 => 42,  84 => 36,  61 => 23,  56 => 20,  44 => 14,  36 => 11,  27 => 8,  359 => 135,  356 => 136,  346 => 135,  343 => 132,  341 => 126,  337 => 129,  333 => 109,  331 => 127,  325 => 124,  322 => 117,  317 => 116,  314 => 115,  311 => 113,  305 => 111,  302 => 110,  299 => 108,  293 => 106,  290 => 105,  286 => 102,  280 => 99,  277 => 97,  271 => 95,  268 => 94,  265 => 95,  254 => 92,  251 => 91,  243 => 95,  226 => 71,  223 => 84,  220 => 68,  201 => 71,  198 => 70,  195 => 69,  192 => 68,  178 => 69,  171 => 61,  168 => 59,  162 => 57,  159 => 56,  152 => 59,  146 => 57,  142 => 58,  136 => 52,  130 => 53,  115 => 47,  112 => 46,  91 => 34,  77 => 32,  69 => 28,  65 => 23,  53 => 20,  47 => 18,  32 => 9,  22 => 3,  101 => 45,  98 => 40,  92 => 41,  88 => 36,  85 => 35,  78 => 27,  74 => 30,  71 => 27,  67 => 24,  55 => 18,  52 => 17,  49 => 16,  40 => 16,  34 => 10,  31 => 8,  29 => 7,  26 => 6,  24 => 4,  21 => 2,  284 => 98,  281 => 110,  278 => 109,  276 => 109,  273 => 108,  269 => 105,  266 => 104,  263 => 102,  259 => 96,  256 => 94,  242 => 87,  239 => 86,  236 => 85,  233 => 84,  230 => 82,  228 => 89,  225 => 88,  222 => 86,  217 => 84,  214 => 66,  211 => 65,  208 => 82,  205 => 81,  202 => 79,  200 => 77,  197 => 76,  194 => 75,  188 => 72,  185 => 56,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 66,  167 => 64,  164 => 62,  161 => 60,  143 => 59,  140 => 57,  137 => 54,  134 => 53,  131 => 54,  128 => 53,  125 => 49,  122 => 39,  119 => 49,  116 => 48,  113 => 45,  108 => 40,  105 => 47,  102 => 43,  100 => 42,  97 => 44,  95 => 40,  93 => 37,  90 => 40,  86 => 35,  83 => 34,  81 => 36,  79 => 35,  76 => 33,  73 => 30,  70 => 31,  68 => 25,  66 => 28,  64 => 25,  62 => 22,  59 => 24,  57 => 20,  54 => 19,  50 => 17,  46 => 15,  43 => 17,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 12,  30 => 8,  28 => 7,  25 => 5,  23 => 3,  19 => 1,);
    }
}
