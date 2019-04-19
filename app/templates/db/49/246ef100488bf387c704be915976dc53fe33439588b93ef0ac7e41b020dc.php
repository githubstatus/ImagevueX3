<?php

/* partials/file.html */
class __TwigTemplate_db49246ef100488bf387c704be915976dc53fe33439588b93ef0ac7e41b020dc extends Twig_Template
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
        $context["image_page"] = call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null))), "html"));
        // line 4
        $context["preview_image_url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), ".")));
        // line 5
        $context["image_ratio"] = (($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "height") / $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "width")) * 100);
        // line 6
        $context["date"] = $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "date_taken", array(), "array");
        // line 7
        echo "
";
        // line 9
        if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["parent_images"]) ? $context["parent_images"] : null))) > 1)) {
            // line 10
            echo "<div class=\"article-nav\">

\t";
            // line 13
            echo "\t";
            if ((isset($context["next_image"]) ? $context["next_image"] : null)) {
                // line 14
                echo "\t\t";
                $context["url"] = (("../" . call_user_func_array($this->env->getFunction('getSibling')->getCallable(), array(call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "file_name")))))) . "/");
                // line 15
                echo "\t\t<a href=\"";
                echo (isset($context["url"]) ? $context["url"] : null);
                echo "\" class=\"next\"><span>";
                echo (($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "title", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "title"), $this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "name")))) : ($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "name")));
                echo "</span></a>
\t";
            }
            // line 17
            echo "
\t";
            // line 19
            echo "\t";
            if ((isset($context["prev_image"]) ? $context["prev_image"] : null)) {
                // line 20
                echo "\t\t";
                $context["url"] = (("../" . call_user_func_array($this->env->getFunction('getSibling')->getCallable(), array(call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "file_name")))))) . "/");
                // line 21
                echo "\t\t<a href=\"";
                echo (isset($context["url"]) ? $context["url"] : null);
                echo "\" class=\"previous\"><span>";
                echo (($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "title", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "title"), $this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "name")))) : ($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "name")));
                echo "</span></a>
\t";
            }
            // line 23
            echo "

\t";
            // line 35
            echo "</div>
";
        }
        // line 37
        echo "
";
        // line 39
        $context["fotomoto"] = "";
        // line 40
        $context["fotomoto_collection"] = "";
        // line 41
        if ((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "enabled") && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "store_id")) && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "enabled_page"))) {
            // line 42
            echo "\t";
            if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "buy_button")) {
                // line 43
                echo "\t\t";
                $context["fotomoto"] = " file-fotomoto file-fotomoto-buybutton";
                // line 44
                echo "\t";
            } else {
                // line 45
                echo "\t\t";
                $context["fotomoto"] = " file-fotomoto";
                // line 46
                echo "\t";
            }
            // line 47
            echo "\t";
            if (call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "collection")))) {
                // line 48
                echo "\t\t";
                $context["fotomoto_collection"] = ((" data-fotomoto-collection=\"" . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "collection")))) . "\"");
                // line 49
                echo "\t";
            }
        }
        // line 51
        echo "
";
        // line 53
        $context["data_exif"] = "";
        // line 54
        $context["meta"] = "";
        // line 55
        $context["data_geo"] = "";
        // line 56
        if ($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif")) {
            // line 57
            echo "
\t";
            // line 59
            echo "\t";
            if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "popup"), "caption"), "exif")) {
                // line 60
                echo "\t\t";
                $context["exif_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "popup"), "caption"), "exif_items"), ","));
                // line 61
                echo "\t\t";
                if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["exif_items"]) ? $context["exif_items"] : null))) > 0)) {
                    // line 62
                    echo "
\t\t\t";
                    // line 68
                    echo "
\t\t\t";
                    // line 69
                    $context["exif_array"] = array();
                    // line 70
                    echo "\t\t\t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["exif_items"]) ? $context["exif_items"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
                        if ($this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), (isset($context["key"]) ? $context["key"] : null), array(), "array")) {
                            // line 71
                            echo "\t\t    ";
                            $context["exif_array"] = call_user_func_array($this->env->getFilter('merge')->getCallable(), array((isset($context["exif_array"]) ? $context["exif_array"] : null), array((isset($context["key"]) ? $context["key"] : null) => $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), (isset($context["key"]) ? $context["key"] : null), array(), "array"))));
                            // line 72
                            echo "\t\t    ";
                            $context["meta"] = ((((((((isset($context["meta"]) ? $context["meta"] : null) . "<div class=\"row file-exif-") . (isset($context["key"]) ? $context["key"] : null)) . "\"><div class=\"small-6 columns file-exif-key\"><span>") . call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('title')->getCallable(), array($this->env, (isset($context["key"]) ? $context["key"] : null))), array("_" => " ")))) . "</span></div><div class=\"small-6 columns file-exif-value styled\">") . $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), (isset($context["key"]) ? $context["key"] : null), array(), "array")) . "</div></div>");
                            // line 73
                            echo "\t\t\t";
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 74
                    echo "\t\t\t";
                    if (call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["exif_array"]) ? $context["exif_array"] : null)))) {
                        $context["data_exif"] = ((" data-exif=\"" . call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('json_encode')->getCallable(), array((isset($context["exif_array"]) ? $context["exif_array"] : null))), "html_attr"))) . "\"");
                    }
                    // line 75
                    echo "
\t\t";
                }
                // line 77
                echo "\t";
            }
            // line 78
            echo "
\t";
            // line 80
            echo "\t";
            if (($this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "latitude") && $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "longitude"))) {
                // line 81
                echo "\t\t";
                $context["geo"] = (($this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "latitude") . ",") . $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "longitude"));
                // line 82
                echo "\t\t";
                $context["map_embed_src"] = (("https://www.google.com/maps/embed/v1/place?q=" . (isset($context["geo"]) ? $context["geo"] : null)) . "&amp;key=AIzaSyDRp6xla9SxUmTBu6l_kprhjjI9e5-EVZk");
                // line 83
                echo "\t\t";
                $context["map_link_src"] = ("https://www.google.com/maps/search/?api=1&query=" . (isset($context["geo"]) ? $context["geo"] : null));
                // line 84
                echo "\t\t";
                $context["map_embed_button_item"] = (((("<button data-href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-popup-href=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"button small button-map\" data-popup-class=\"x3-popup-iframe-full\" data-popup></button>");
                // line 85
                echo "\t\t";
                $context["map_button_popup"] = (((("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-embed-modal=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"button small button-map\" target=\"_blank\"></a>");
                // line 86
                echo "\t\t";
                $context["map_link_popup"] = (((("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-embed-modal=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"link-map\" target=\"_blank\"></a>");
                // line 87
                echo "\t\t";
                $context["map_button"] = (("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" class=\"button small button-map\" target=\"_blank\"></a>");
                // line 88
                echo "\t\t";
                $context["map_link"] = (("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" class=\"link-map\" target=\"_blank\"></a>");
                // line 89
                echo "\t\t";
                if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "popup"), "caption"), "map")) {
                    $context["data_geo"] = ((" data-geo=\"" . (isset($context["geo"]) ? $context["geo"] : null)) . "\"");
                }
                // line 90
                echo "\t";
            }
        }
        // line 92
        echo "
";
        // line 94
        if ((isset($context["geo"]) ? $context["geo"] : null)) {
            // line 95
            echo "\t";
            $context["page_title"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null), array("{latitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude"), "{longitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"), "{map_embed_src}" => (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null), "{map_link_src}" => (isset($context["map_link_src"]) ? $context["map_link_src"] : null), "{map_button_popup}" => (isset($context["map_button_popup"]) ? $context["map_button_popup"] : null), "{map_link_popup}" => (isset($context["map_link_popup"]) ? $context["map_link_popup"] : null), "{map_button}" => (isset($context["map_button"]) ? $context["map_button"] : null), "{map_link}" => (isset($context["map_link"]) ? $context["map_link"] : null))));
            // line 96
            echo "\t";
            if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null))))) {
                // line 97
                echo "\t\t";
                $context["image_description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), array("{latitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude"), "{longitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"), "{map_embed_src}" => (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null), "{map_link_src}" => (isset($context["map_link_src"]) ? $context["map_link_src"] : null), "{map_button_popup}" => (isset($context["map_button_popup"]) ? $context["map_button_popup"] : null), "{map_link_popup}" => (isset($context["map_link_popup"]) ? $context["map_link_popup"] : null), "{map_button}" => (isset($context["map_button"]) ? $context["map_button"] : null), "{map_link}" => (isset($context["map_link"]) ? $context["map_link"] : null))));
                // line 98
                echo "\t";
            }
        }
        // line 100
        echo "
";
        // line 102
        echo "<div class=\"module row file gallery";
        echo (isset($context["fotomoto"]) ? $context["fotomoto"] : null);
        echo "\"";
        echo (isset($context["fotomoto_collection"]) ? $context["fotomoto_collection"] : null);
        echo ">
  <div data-options=\"caption:\" class=\"images clearfix context small-12 medium-10 large-8 small-centered columns narrower text-center frame";
        // line 103
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled") == true)) {
            echo " x3-hover-icon-primary";
        }
        echo "\">

  ";
        // line 106
        echo "
  <h1 class=\"title\">";
        // line 107
        echo (isset($context["page_title"]) ? $context["page_title"] : null);
        echo "</h1>
  ";
        // line 108
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null))))) {
            echo "<h2 class=\"subheader\">";
            echo (isset($context["image_description"]) ? $context["image_description"] : null);
            echo "</h2>";
        }
        // line 109
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["date"]) ? $context["date"] : null))))) {
            echo "<h6 class=\"date\"><time itemprop=\"dateCreated\" datetime=\"";
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"));
            echo "\">";
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
            echo "</time></h6>";
        }
        // line 110
        echo "
  ";
        // line 112
        echo "\t<a href=\"";
        echo call_user_func_array($this->env->getFilter('setpath')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "permalink"), array(" " => "_"))))), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        echo "\" class=\"file-back\"></a>

\t";
        // line 115
        echo "\t<div class=\"gallery\">
\t\t<a class=\"item img-link item-link";
        // line 116
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled") == true)) {
            echo " x3-popup";
        }
        echo "\"";
        echo (isset($context["data_exif"]) ? $context["data_exif"] : null);
        echo (isset($context["data_geo"]) ? $context["data_geo"] : null);
        echo " id=\"image-";
        echo call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('attribute_friendly')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "slug"))), "1"));
        echo "\" data-width=\"";
        echo $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "width");
        echo "\" data-height=\"";
        echo $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "height");
        echo "\" href=\"";
        echo (isset($context["image_page"]) ? $context["image_page"] : null);
        echo "\" data-image=\"";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null)));
        echo "\" data-title=\"";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["page_title"]) ? $context["page_title"] : null), "html"));
        echo "\" data-description=\"";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["image_description"]) ? $context["image_description"] : null), "html"));
        echo "\" data-date=\"";
        echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
        echo "\">
\t\t\t<figure>
\t\t\t\t<div class=\"image-container\" style=\"padding-bottom:";
        // line 118
        echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
        echo "%;\">
\t\t\t\t\t<img data-src=\"";
        // line 119
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null)));
        echo "\" alt=\"";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null)))));
        echo "\">
\t\t\t\t</div>
\t\t\t</figure>
\t\t</a>
\t</div>

\t";
        // line 126
        echo "\t";
        if ((isset($context["meta"]) ? $context["meta"] : null)) {
            echo "<div class=\"file-exif\">";
            echo (isset($context["meta"]) ? $context["meta"] : null);
            echo "</div>";
        }
        // line 127
        echo "
\t";
        // line 129
        echo "\t";
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "disqus_shortname") && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "plugins"), "disqus"), "image"))) {
            // line 130
            echo "\t\t<hr>
\t\t<div id=\"comments\">
\t\t\t<div>
\t\t\t\t<h2>Comments</h2>
\t\t\t\t<div id=\"disqus_thread\"></div>
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 138
        echo "
\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "partials/file.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  346 => 138,  336 => 130,  333 => 129,  330 => 127,  323 => 126,  312 => 119,  308 => 118,  282 => 116,  279 => 115,  273 => 112,  270 => 110,  261 => 109,  255 => 108,  251 => 107,  248 => 106,  241 => 103,  234 => 102,  231 => 100,  227 => 98,  224 => 97,  221 => 96,  218 => 95,  216 => 94,  213 => 92,  209 => 90,  204 => 89,  201 => 88,  198 => 87,  195 => 86,  192 => 85,  189 => 84,  186 => 83,  183 => 82,  180 => 81,  177 => 80,  174 => 78,  171 => 77,  167 => 75,  162 => 74,  155 => 73,  152 => 72,  149 => 71,  143 => 70,  141 => 69,  138 => 68,  135 => 62,  132 => 61,  129 => 60,  126 => 59,  123 => 57,  121 => 56,  119 => 55,  117 => 54,  115 => 53,  112 => 51,  108 => 49,  105 => 48,  102 => 47,  99 => 46,  96 => 45,  93 => 44,  90 => 43,  87 => 42,  85 => 41,  83 => 40,  81 => 39,  78 => 37,  74 => 35,  70 => 23,  62 => 21,  59 => 20,  56 => 19,  53 => 17,  45 => 15,  42 => 14,  39 => 13,  35 => 10,  33 => 9,  30 => 7,  28 => 6,  26 => 5,  24 => 4,  22 => 3,  19 => 1,);
    }
}
