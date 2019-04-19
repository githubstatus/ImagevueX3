<?php

/* partials/head.html */
class __TwigTemplate_bbf84e8334aa77fc3e030e582b6b9bca6aa66114b7201078c756af50f9885fea extends Twig_Template
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
        echo "<html>
";
        // line 2
        $context["page_title_stripped"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null))), "html"))));
        // line 3
        $context["page_description_stripped"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null))), "html"))));
        // line 4
        echo "<head>

";
        // line 7
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_analytics")) {
            // line 8
            echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_analytics");
            echo "\"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '";
            // line 13
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_analytics");
            echo "');
</script>
";
        }
        // line 16
        echo "
  ";
        // line 18
        echo "  <meta charset=\"utf-8\">
  <title>";
        // line 19
        echo (isset($context["page_title_stripped"]) ? $context["page_title_stripped"] : null);
        echo "</title>
  ";
        // line 20
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null))))) {
            // line 21
            echo "  <meta name=\"description\" content=\"";
            echo (isset($context["page_description_stripped"]) ? $context["page_description_stripped"] : null);
            echo "\">
  ";
        }
        // line 23
        echo "
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
  <link rel=\"canonical\" href=\"";
        // line 25
        echo (isset($context["absolutepath_page"]) ? $context["absolutepath_page"] : null);
        echo "\">

  ";
        // line 28
        echo "  <link rel=\"dns-prefetch\" href=\"//auth.photo.gallery\">
  ";
        // line 29
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo "<link rel=\"dns-prefetch\" href=\"//cdn.jsdelivr.net\">";
        }
        // line 30
        echo "  ";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_files")) {
            echo "<link rel=\"dns-prefetch\" href=\"";
            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('lower')->getCallable(), array($this->env, $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_files"))), "/")), "http:")), "https:"));
            echo "\">";
        }
        // line 31
        echo "
  ";
        // line 33
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_author"))))) {
            echo "<link rel=\"author\" href=\"https://plus.google.com/";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_author");
            echo "\">";
        }
        // line 34
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_publisher"))))) {
            echo "<link rel=\"publisher\" href=\"https://plus.google.com/";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_publisher");
            echo "\">";
        }
        // line 35
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_site_verification"))))) {
            echo "<meta name=\"google-site-verification\" content=\"";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "google_site_verification");
            echo "\">";
        }
        // line 36
        echo "
  ";
        // line 38
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "twitter_username"))))) {
            echo "<meta name=\"twitter:site\" content=\"@";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "twitter_username");
            echo "\">";
        }
        // line 39
        echo "
  ";
        // line 41
        echo "  <meta property=\"og:title\" content=\"";
        echo (isset($context["page_title_stripped"]) ? $context["page_title_stripped"] : null);
        echo "\">
  ";
        // line 42
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null))))) {
            echo "<meta property=\"og:description\" content=\"";
            echo (isset($context["page_description_stripped"]) ? $context["page_description_stripped"] : null);
            echo "\">";
        }
        // line 43
        echo "  <meta property=\"og:url\" content=\"";
        echo (isset($context["absolutepath_page"]) ? $context["absolutepath_page"] : null);
        echo "\">
  <meta property=\"og:type\" content=\"website\">
  <meta property=\"og:updated_time\" content=\"";
        // line 45
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "updated");
        echo "\">
  ";
        // line 46
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "facebook_author"))))) {
            echo "<meta property=\"article:author\" content=\"";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "facebook_author");
            echo "\">";
        }
        // line 47
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "facebook_publisher"))))) {
            echo "<meta property=\"article:publisher\" content=\"";
            echo $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "facebook_publisher");
            echo "\">";
        }
        // line 48
        echo "
  ";
        // line 50
        echo "  <meta property=\"og:image\" content=\"";
        echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_full"]) ? $context["preview_image_full"] : null))), array(" " => "%20")));
        echo "\">

  ";
        // line 53
        echo "  ";
        $context["imgInfo"] = call_user_func_array($this->env->getFunction('getimginfo')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null)));
        // line 54
        echo "  ";
        if ($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), "mime", array(), "array")) {
            echo "<meta property=\"og:image:type\" content=\"";
            echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), "mime", array(), "array");
            echo "\">";
        }
        // line 55
        echo "  ";
        if ($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array")) {
            echo "<meta property=\"og:image:width\" content=\"";
            echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array");
            echo "\" />";
        }
        // line 56
        echo "  ";
        if ($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array")) {
            echo "<meta property=\"og:image:height\" content=\"";
            echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array");
            echo "\" />";
        }
        // line 57
        echo "
  ";
        // line 59
        echo "  ";
        $context["favicon"] = call_user_func_array($this->env->getFunction('firstImage')->getCallable(), array("./content/custom/favicon"));
        // line 60
        echo "  ";
        if ((isset($context["favicon"]) ? $context["favicon"] : null)) {
            // line 61
            echo "  <link rel=\"icon\" href=\"";
            echo (isset($context["assetspath"]) ? $context["assetspath"] : null);
            echo (isset($context["favicon"]) ? $context["favicon"] : null);
            echo "\">
  ";
        }
        // line 63
        echo "
  ";
        // line 65
        echo "  ";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "feed")) {
            // line 66
            echo "  <link href=\"";
            echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
            echo "/feed/\" type=\"application/atom+xml\" rel=\"alternate\" title=\"Atom Feed\">
  ";
        }
        // line 68
        echo "
  ";
        // line 70
        echo "  ";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 71
            echo "<script>
var css_counter = 0;
function imagevue_(){
\tcss_counter ++;
\tif(css_counter === 1) imagevue();
};
function cssFail(){
\tcss_counter --;
\tvar l = document.createElement('link');
\tl.onload = imagevue_;
\tl.rel = 'stylesheet';
\tl.id = '";
            // line 82
            echo $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin");
            echo "';
\tl.href = '";
            // line 83
            echo (isset($context["local_css"]) ? $context["local_css"] : null);
            echo "';
\tdocument.getElementsByTagName('head')[0].appendChild(l);
}
</script>
  ";
        }
        // line 88
        echo "
  ";
        // line 90
        echo "  <link rel=\"stylesheet\" id=\"";
        echo $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin");
        echo "\" href=\"";
        echo (isset($context["core_css"]) ? $context["core_css"] : null);
        echo "\"";
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            echo " onerror=\"cssFail();\"";
        }
        echo ">

\t";
        // line 93
        echo "\t";
        if (((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "font"), "font")))) && ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "font"), "font") != "none"))) {
            // line 94
            echo "\t<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=";
            echo call_user_func_array($this->env->getFilter('getfontstring')->getCallable(), array((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "font", array(), "any", false, true), "font", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "font", array(), "any", false, true), "font"), "Lato:400,700,900,400italic,700italic,900italic"))) : ("Lato:400,700,900,400italic,700italic,900italic"))));
            echo "\">
\t";
        }
        // line 96
        echo "
\t";
        // line 98
        echo "\t";
        echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('removeComments')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "head")))));
        echo "

\t";
        // line 101
        echo "  <style id=\"default-fonts\"><!-- body,h1,h2,h3,h4,h5,h6 {font-family: \"Helvetica Neue\",Helvetica,Roboto,Arial,sans-serif;} --></style>

  ";
        // line 104
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "css"))))) {
            // line 105
            echo "  <style id=\"custom-css\"><!-- ";
            echo call_user_func_array($this->env->getFilter('minify')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "css")));
            echo " --></style>
  ";
        }
        // line 107
        echo "
  ";
        // line 109
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "logo_css"))))) {
            // line 110
            echo "  <style id=\"logo\"><!-- ";
            echo call_user_func_array($this->env->getFilter('minify')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "back"), "custom"), "logo_css")));
            echo " --></style>
  ";
        }
        // line 112
        echo "
  ";
        // line 114
        echo "  ";
        $context["custom_css_files"] = call_user_func_array($this->env->getFunction('x3_glob')->getCallable(), array("./content/custom/files/css/*include*.css", (("<link rel=\"stylesheet\" id=\"custom_css_{{index}}\" href=\"" . (isset($context["assetspath"]) ? $context["assetspath"] : null)) . "/content/custom/files/css/{{basename}}\">")));
        // line 115
        echo "  ";
        if ((isset($context["custom_css_files"]) ? $context["custom_css_files"] : null)) {
            echo (isset($context["custom_css_files"]) ? $context["custom_css_files"] : null);
        }
        // line 116
        echo "
  ";
        // line 118
        echo "  <style id=\"x3app\"></style>

</head>

";
        // line 122
        $context["layout"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "layout", array(), "any", false, true), "layout", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style", array(), "any", false, true), "layout", array(), "any", false, true), "layout"), "topbar-float"))) : ("topbar-float"));
        // line 123
        if (twig_in_filter("topbar", (isset($context["layout"]) ? $context["layout"] : null))) {
            $context["fixed"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "layout"), "fixed");
        }
        // line 124
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "layout"), "wide")) {
            $context["wide"] = "wide";
        }
        // line 125
        $context["data_layout"] = call_user_func_array($this->env->getFilter('cleanData')->getCallable(), array((((((((((((((((((($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "include"), "body") . " ") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "body")) . " ") . (isset($context["layout"]) ? $context["layout"] : null)) . " ") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin")) . " ") . (isset($context["fixed"]) ? $context["fixed"] : null)) . " ") . (isset($context["wide"]) ? $context["wide"] : null)) . " ") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "clear")) . " x3-") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "template_name")) . " slug-") . call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('attribute_friendly')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "slug"))), "index"))) . " page-") . call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('attribute_friendly')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), "/")))), "index")))));
        // line 126
        echo "
<body class=\"fa-loading initializing ";
        // line 127
        echo (isset($context["data_layout"]) ? $context["data_layout"] : null);
        echo "\" data-include=\"";
        echo call_user_func_array($this->env->getFilter('cleanData')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "include"), "body")));
        echo "\">
<div class=\"x3-loader\" title=\"loading\"></div>
<div class=\"sb-site-container\">
  <div>

    ";
        // line 133
        echo "    ";
        $this->env->loadTemplate("partials/nav/header.html")->display($context);
        // line 134
        echo "
  \t<main class=\"main\" id=\"content\">";
    }

    public function getTemplateName()
    {
        return "partials/head.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 125,  335 => 124,  331 => 123,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 112,  303 => 110,  300 => 109,  297 => 107,  291 => 105,  288 => 104,  284 => 101,  269 => 94,  266 => 93,  254 => 90,  251 => 88,  243 => 83,  239 => 82,  226 => 71,  223 => 70,  220 => 68,  214 => 66,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 55,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 47,  146 => 46,  142 => 45,  136 => 43,  130 => 42,  115 => 38,  112 => 36,  69 => 25,  65 => 23,  53 => 19,  47 => 16,  32 => 8,  22 => 2,  108 => 45,  105 => 35,  101 => 41,  98 => 34,  95 => 39,  92 => 38,  88 => 31,  85 => 34,  81 => 30,  78 => 30,  74 => 28,  71 => 26,  67 => 23,  55 => 17,  52 => 16,  49 => 15,  40 => 11,  34 => 9,  31 => 8,  29 => 7,  26 => 4,  24 => 3,  21 => 2,  278 => 98,  275 => 96,  272 => 103,  270 => 102,  267 => 100,  263 => 98,  260 => 97,  257 => 96,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 84,  219 => 83,  216 => 82,  211 => 65,  208 => 63,  205 => 78,  202 => 77,  199 => 76,  196 => 75,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 63,  167 => 62,  164 => 61,  161 => 60,  158 => 59,  155 => 57,  137 => 56,  134 => 54,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 46,  110 => 45,  107 => 44,  102 => 43,  99 => 42,  96 => 40,  94 => 39,  91 => 33,  89 => 36,  87 => 35,  84 => 33,  80 => 31,  77 => 29,  73 => 28,  70 => 27,  68 => 26,  66 => 25,  64 => 22,  62 => 21,  59 => 21,  57 => 20,  54 => 18,  50 => 18,  46 => 13,  43 => 12,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 7,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
