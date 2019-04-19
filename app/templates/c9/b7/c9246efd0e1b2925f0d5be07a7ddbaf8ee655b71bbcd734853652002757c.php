<?php

/* partials/module.context.html */
class __TwigTemplate_c9b7c9246efd0e1b2925f0d5be07a7ddbaf8ee655b71bbcd734853652002757c extends Twig_Template
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
        echo "
";
        // line 5
        $context["p"] = (isset($context["page"]) ? $context["page"] : null);
        // line 6
        $context["context"] = $this->getAttribute((isset($context["p"]) ? $context["p"] : null), "context");
        // line 7
        $context["page_description"] = $this->getAttribute((isset($context["p"]) ? $context["p"] : null), "description");
        // line 8
        $context["content"] = call_user_func_array($this->env->getFilter('escapecode')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(((((call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["p"]) ? $context["p"] : null), "include"), "content_prepend"))) . " ") . $this->getAttribute((isset($context["p"]) ? $context["p"] : null), "content")) . " ") . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["p"]) ? $context["p"] : null), "include"), "content_append")))), array("{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files"), "[contact]" => "<form data-abide class=\"contactform\"><div><input required type=\"text\" name=\"name\" placeholder=\"Name\"></div><div><input required type=\"email\" name=\"email\" placeholder=\"Email\"></div><div><textarea required rows=6 name=\"message\" placeholder=\"What&#39;s up?\"></textarea></div><button type=\"submit\">Send</button></form>")))))));
        // line 9
        echo "
";
        // line 11
        $context["date"] = (($this->getAttribute((isset($context["p"]) ? $context["p"] : null), "date", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["p"]) ? $context["p"] : null), "date"), $this->getAttribute((isset($context["p"]) ? $context["p"] : null), "updated")))) : ($this->getAttribute((isset($context["p"]) ? $context["p"] : null), "updated")));
        // line 12
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "date_format") == "timeago")) {
            // line 13
            echo "\t";
            $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
            // line 14
            echo "\t";
            $context["date_class"] = "date timeago";
        } else {
            // line 16
            echo "\t";
            $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format"), "d F Y"))) : ("d F Y"))));
            // line 17
            echo "\t";
            $context["date_class"] = "date";
        }
        // line 19
        $context["time_tag"] = (((((("<time itemprop=\"dateCreated\" datetime=\"" . call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"))) . "\" class=\"") . (isset($context["date_class"]) ? $context["date_class"] : null)) . "\">") . (isset($context["date_formatted"]) ? $context["date_formatted"] : null)) . "</time>");
        // line 20
        echo "
";
        // line 23
        $context["items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "items"), ","));
        // line 24
        echo "
";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 27
            echo "
\t";
            // line 29
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                // line 30
                echo "\t<h1 class=\"title style-icon\"><span>";
                echo (isset($context["page_title"]) ? $context["page_title"] : null);
                echo "</span></h1>
\t";
            }
            // line 32
            echo "
\t";
            // line 34
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                // line 35
                echo "\t<h1 class=\"title\"><span>";
                echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "label");
                echo "</span></h1>
\t";
            }
            // line 37
            echo "
\t";
            // line 39
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "amount")) {
                // line 40
                echo "\t";
                $context["amount"] = call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null)));
                // line 41
                echo "\t<h6 class=\"amount amount-";
                echo (isset($context["amount"]) ? $context["amount"] : null);
                echo "\"><span>";
                echo (isset($context["amount"]) ? $context["amount"] : null);
                echo " ";
                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["amount"]) ? $context["amount"] : null), "image", "images"));
                echo "</span></h6>
\t";
            }
            // line 43
            echo "
\t";
            // line 45
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "folders_amount")) {
                // line 46
                echo "\t";
                $context["folders_amount"] = $this->getAttribute((isset($context["folder"]) ? $context["folder"] : null), "children_count");
                // line 47
                echo "\t<h6 class=\"folder_amount folder-amount-";
                echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                echo "\"><span>";
                echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                echo " ";
                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["folders_amount"]) ? $context["folders_amount"] : null), "album", "albums"));
                echo "</span></h6>
\t";
            }
            // line 49
            echo "
\t";
            // line 51
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                // line 52
                echo "\t<h6 class=\"date\">";
                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                echo "</h6>
\t";
            }
            // line 54
            echo "
\t";
            // line 56
            echo "\t";
            if ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null)))))) {
                // line 57
                echo "\t<h2 class=\"subheader\">";
                echo (isset($context["page_description"]) ? $context["page_description"] : null);
                echo "</h2>
\t";
            }
            // line 59
            echo "
\t";
            // line 61
            echo "\t";
            if (((isset($context["item"]) ? $context["item"] : null) == "preview")) {
                // line 62
                echo "
\t";
                // line 64
                echo "\t";
                if ($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "crop"), "enabled")) {
                    // line 65
                    echo "\t\t";
                    $context["crop_ratio"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "crop"), "crop"), 1, array(), "array") / $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "crop"), "crop"), 0, array(), "array")) * 100);
                    // line 66
                    echo "\t\t";
                    $context["data_crop"] = ((((" data-crop=\"" . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "crop"), "crop"), 0, array(), "array")) . ":") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "crop"), "crop"), 1, array(), "array")) . "\"");
                    // line 67
                    echo "\t";
                }
                // line 68
                echo "
\t";
                // line 70
                echo "\t";
                $context["preview_image_url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), ".")));
                // line 71
                echo "
\t";
                // line 73
                echo "  ";
                if (((isset($context["preview_img"]) ? $context["preview_img"] : null) == "./app/public/images/default.png")) {
                    // line 74
                    echo "  \t";
                    $context["imgInfo"] = array(0 => 1280, 1 => 1280);
                    // line 75
                    echo "  \t";
                    $context["image_ratio"] = 100;
                    // line 76
                    echo "  ";
                } else {
                    // line 77
                    echo "\t\t";
                    $context["imgInfo"] = call_user_func_array($this->env->getFunction('getimginfo')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null)));
                    // line 78
                    echo "\t\t";
                    $context["image_ratio"] = ((array_key_exists("crop_ratio", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["crop_ratio"]) ? $context["crop_ratio"] : null), (($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array") / $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array")) * 100)))) : ((($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array") / $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array")) * 100)));
                    // line 79
                    echo "  ";
                }
                // line 80
                echo "
\t";
                // line 82
                echo "\t<div class=\"preview-image x-frame-medium-up images\">
\t\t<a class=\"img-link item-link item popup\" data-width=\"";
                // line 83
                echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array");
                echo "\" data-height=\"";
                echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array");
                echo "\" href=\".\" data-popup-href=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null)));
                echo "\" data-image=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null)));
                echo "\">
\t\t\t<figure>
\t\t\t\t<div class=\"image-container\" style=\"padding-bottom:";
                // line 85
                echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
                echo "%;\">
\t\t\t\t\t<img data-src=\"";
                // line 86
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null)));
                echo "\" data-width=\"";
                echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array");
                echo "\"";
                echo (isset($context["data_crop"]) ? $context["data_crop"] : null);
                echo " alt=\"\">
\t\t\t\t</div>

\t\t\t";
                // line 90
                echo "\t\t\t";
                if ($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "caption"), "enabled")) {
                    // line 91
                    echo "        <figcaption>

        \t";
                    // line 94
                    echo "\t\t\t\t\t";
                    $context["caption_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "caption"), "items"), ","));
                    // line 95
                    echo "
        \t";
                    // line 97
                    echo "        \t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["caption_items"]) ? $context["caption_items"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                        // line 98
                        echo "
        \t\t";
                        // line 100
                        echo "        \t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                            // line 101
                            echo "        \t\t<span class=\"title\">";
                            echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                            echo "</span>
        \t\t";
                        }
                        // line 103
                        echo "
        \t\t";
                        // line 105
                        echo "        \t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                            // line 106
                            echo "        \t\t<span class=\"title\">";
                            echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "label");
                            echo "</span>
        \t\t";
                        }
                        // line 108
                        echo "
        \t\t";
                        // line 110
                        echo "        \t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "amount")) {
                            // line 111
                            echo "\t\t\t\t\t\t";
                            $context["amount"] = call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null)));
                            // line 112
                            echo "        \t\t<span class=\"amount amount-";
                            echo (isset($context["amount"]) ? $context["amount"] : null);
                            echo "\">";
                            echo (isset($context["amount"]) ? $context["amount"] : null);
                            echo " ";
                            echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["amount"]) ? $context["amount"] : null), "image", "images"));
                            echo "</span>
        \t\t";
                        }
                        // line 114
                        echo "
        \t\t";
                        // line 116
                        echo "        \t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "folders_amount")) {
                            // line 117
                            echo "        \t\t";
                            $context["folders_amount"] = $this->getAttribute((isset($context["folder"]) ? $context["folder"] : null), "children_count");
                            // line 118
                            echo "        \t\t<span class=\"folder_amount folder-amount-";
                            echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                            echo "\">";
                            echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                            echo " ";
                            echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["folders_amount"]) ? $context["folders_amount"] : null), "album", "albums"));
                            echo "</span>
        \t\t";
                        }
                        // line 120
                        echo "
        \t\t";
                        // line 122
                        echo "        \t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                            // line 123
                            echo "\t\t\t\t\t\t\t";
                            echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                            echo "
        \t\t";
                        }
                        // line 125
                        echo "
        \t\t";
                        // line 127
                        echo "        \t\t";
                        if ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null)))))) {
                            // line 128
                            echo "        \t\t\t<span class=\"description\">";
                            echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["page_description"]) ? $context["page_description"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                            echo "</span>
        \t\t";
                        }
                        // line 130
                        echo "
        \t\t";
                        // line 132
                        echo "        \t\t";
                        if ((((isset($context["item"]) ? $context["item"] : null) == "content") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["content"]) ? $context["content"] : null)))))) {
                            // line 133
                            echo "        \t\t\t<span class=\"content\">";
                            echo (isset($context["content"]) ? $context["content"] : null);
                            echo "</span>
        \t\t";
                        }
                        // line 135
                        echo "
        \t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 137
                    echo "        </figcaption>
      ";
                }
                // line 139
                echo "
\t\t\t</figure>
\t\t</a>
\t</div>
\t";
            }
            // line 144
            echo "
\t";
            // line 146
            echo "\t";
            if ((((isset($context["item"]) ? $context["item"] : null) == "content") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["content"]) ? $context["content"] : null)))))) {
                // line 147
                echo "\t\t";
                // line 149
                echo "\t\t<div class=\"content\">";
                echo (isset($context["content"]) ? $context["content"] : null);
                echo "</div>
\t";
            }
            // line 151
            echo "
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "partials/module.context.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  384 => 151,  378 => 149,  376 => 147,  373 => 146,  370 => 144,  363 => 139,  359 => 137,  352 => 135,  346 => 133,  343 => 132,  340 => 130,  334 => 128,  328 => 125,  322 => 123,  319 => 122,  316 => 120,  306 => 118,  287 => 112,  281 => 110,  249 => 97,  246 => 95,  193 => 76,  190 => 75,  187 => 74,  184 => 73,  181 => 71,  175 => 68,  172 => 67,  169 => 66,  166 => 65,  163 => 64,  160 => 62,  148 => 57,  145 => 56,  133 => 51,  111 => 43,  83 => 34,  174 => 69,  157 => 61,  154 => 59,  114 => 45,  86 => 35,  60 => 23,  48 => 17,  51 => 19,  42 => 14,  127 => 51,  124 => 49,  120 => 47,  117 => 46,  106 => 42,  103 => 41,  100 => 39,  93 => 37,  79 => 34,  76 => 32,  58 => 22,  45 => 16,  38 => 12,  90 => 43,  61 => 24,  56 => 20,  44 => 12,  36 => 11,  27 => 6,  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 125,  335 => 124,  331 => 127,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 112,  303 => 117,  300 => 116,  297 => 114,  291 => 105,  288 => 104,  284 => 111,  269 => 105,  266 => 103,  254 => 98,  251 => 88,  243 => 94,  239 => 91,  226 => 86,  223 => 70,  220 => 68,  214 => 66,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 70,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 59,  146 => 46,  142 => 54,  136 => 52,  130 => 49,  115 => 46,  112 => 36,  69 => 28,  65 => 23,  53 => 19,  47 => 16,  32 => 8,  22 => 3,  108 => 47,  105 => 45,  101 => 41,  98 => 40,  95 => 39,  92 => 37,  88 => 29,  85 => 34,  81 => 34,  78 => 27,  74 => 30,  71 => 29,  67 => 24,  55 => 17,  52 => 19,  49 => 18,  40 => 13,  34 => 9,  31 => 8,  29 => 7,  26 => 5,  24 => 4,  21 => 2,  278 => 108,  275 => 96,  272 => 106,  270 => 102,  267 => 100,  263 => 98,  260 => 101,  257 => 100,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 85,  219 => 83,  216 => 82,  211 => 83,  208 => 82,  205 => 80,  202 => 79,  199 => 78,  196 => 77,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 59,  155 => 57,  137 => 54,  134 => 53,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 45,  110 => 48,  107 => 44,  102 => 43,  99 => 43,  96 => 42,  94 => 41,  91 => 39,  89 => 36,  87 => 35,  84 => 36,  80 => 32,  77 => 32,  73 => 30,  70 => 25,  68 => 27,  66 => 26,  64 => 26,  62 => 22,  59 => 23,  57 => 20,  54 => 19,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 6,  25 => 5,  23 => 3,  19 => 1,);
    }
}
