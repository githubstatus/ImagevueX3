<?php

/* partials/module.gallery.html */
class __TwigTemplate_f66190562b4bb614743865488354d8efd152e9eea2fe5dceae8e13a06b6e21dc extends Twig_Template
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
        // line 6
        $context["settings"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "gallery");
        // line 7
        $context["items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "items"), ","));
        // line 8
        $context["limit"] = $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "limit");
        // line 9
        $context["folder_path"] = (((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "file_path"), "."))) . "/");
        // line 10
        if ((call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["limit"]) ? $context["limit"] : null))) || ((isset($context["limit"]) ? $context["limit"] : null) < 1))) {
            $context["limit"] = 99999;
        }
        // line 11
        $context["exif_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "caption"), "exif_items"), ","));
        // line 12
        echo "
";
        // line 14
        if ((((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_videos"]) ? $context["gallery_videos"] : null))) > 0) && !twig_in_filter("hide-video", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes"))) && !twig_in_filter("video-bottom", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
            // line 15
            echo "\t";
            $this->env->loadTemplate("partials/module.video.html")->display($context);
            // line 16
            echo "\t";
            if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null))) > 0)) {
                // line 17
                echo "\t\t<hr>
\t";
            }
        }
        // line 20
        echo "
";
        // line 22
        $context["nofollow"] = (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "image_noindex")) ? (" rel=\"nofollow\"") : (""));
        // line 23
        echo "
";
        // line 25
        if ((($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "enabled") && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "columns"))) {
            // line 26
            echo "\t";
            $context["crop_ratio"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 1, array(), "array") / $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 0, array(), "array")) * 100);
            // line 27
            echo "\t";
            $context["data_crop"] = ((((" data-crop=\"" . call_user_func_array($this->env->getFilter('round')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 0, array(), "array")))) . ":") . call_user_func_array($this->env->getFilter('round')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 1, array(), "array")))) . "\"");
        }
        // line 29
        echo "
";
        // line 31
        $context["gallery_split_view"] = (($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "enabled") && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "columns"));
        // line 32
        if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
            // line 33
            echo "\t";
            // line 34
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "invert")) {
                // line 35
                echo "\t\t";
                $context["push"] = ("medium-push-" . (12 - $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio")));
                // line 36
                echo "\t\t";
                $context["pull"] = ("medium-pull-" . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio"));
                // line 37
                echo "\t";
            }
        }
        // line 39
        echo "
";
        // line 41
        if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") == "grid")) {
            // line 42
            echo "
\t";
            // line 44
            echo "\t";
            if (($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "space") > (-1))) {
                // line 45
                echo "\t\t";
                $context["ul_style"] = ((" style=\"margin: 0 " . ((((isset($context["width"]) ? $context["width"] : null) == "wide")) ? (($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "space") / 2)) : (((-$this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "space")) / 4)))) . "px\"");
                // line 46
                echo "\t\t";
                $context["li_style"] = ((((" style=\"padding: 0 " . ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "space") / 2)) . "px ") . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "space")) . "px\"");
                // line 47
                echo "\t";
            }
            // line 48
            echo "
\t";
            // line 50
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "use_width")) {
                // line 51
                echo "\t\t";
                $context["ul_open"] = (("<ul class=\"items\"" . (isset($context["ul_style"]) ? $context["ul_style"] : null)) . ">");
                // line 52
                echo "
\t";
                // line 54
                echo "\t";
            } else {
                // line 55
                echo "\t\t";
                $context["block_grid"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "columns"), array(" " => ""))), ","));
                // line 56
                echo "\t\t";
                $context["columns_max"] = call_user_func_array($this->env->getFunction('max')->getCallable(), array(call_user_func_array($this->env->getFunction('min')->getCallable(), array((isset($context["limit"]) ? $context["limit"] : null), call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null))))), 3));
                // line 57
                echo "\t\t";
                $context["small_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"))), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "1")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 58
                echo "\t\t";
                $context["medium_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "2")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 59
                echo "\t\t";
                $context["large_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"), "3"))) : ("3")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 60
                echo "\t\t";
                $context["ul_open"] = (((((((("<ul class=\"small-block-grid-" . (isset($context["small_grid"]) ? $context["small_grid"] : null)) . " medium-block-grid-") . (isset($context["medium_grid"]) ? $context["medium_grid"] : null)) . " large-block-grid-") . (isset($context["large_grid"]) ? $context["large_grid"] : null)) . " items\"") . (isset($context["ul_style"]) ? $context["ul_style"] : null)) . ">");
                // line 61
                echo "\t";
            }
            // line 62
            echo "
\t";
            // line 63
            echo "\t
\t";
            // line 64
            $context["li_open"] = (("<li" . (isset($context["li_style"]) ? $context["li_style"] : null)) . ">");
            // line 65
            echo "\t";
            $context["li_close"] = "</li>";
            // line 66
            echo "\t";
            $context["ul_close"] = "</ul>";
        }
        // line 68
        echo "
";
        // line 70
        echo (isset($context["ul_open"]) ? $context["ul_open"] : null);
        echo "

";
        // line 73
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["gallery_images"]) ? $context["gallery_images"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
            // line 74
            echo "
";
            // line 76
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0") < (isset($context["limit"]) ? $context["limit"] : null))) {
                // line 77
                echo "
\t";
                // line 79
                echo "\t";
                $context["url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "file_path") . "/") . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), ".")));
                // line 80
                echo "\t";
                $context["url_escaped"] = call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["url"]) ? $context["url"] : null)));
                // line 81
                echo "\t";
                $context["image_link"] = (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link")))) : ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link")));
                // line 82
                echo "\t";
                $context["link_target"] = (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "target", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "target"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link_target")))) : ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link_target")));
                // line 83
                echo "\t";
                $context["name_no_ext"] = call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")));
                // line 84
                echo "\t";
                $context["nofollow"] = "";
                // line 85
                echo "
\t";
                // line 87
                echo "\t";
                if ((isset($context["image_link"]) ? $context["image_link"] : null)) {
                    // line 88
                    echo "
\t\t";
                    // line 90
                    echo "\t\t";
                    if ((0 === substr_compare((isset($context["image_link"]) ? $context["image_link"] : null), ":nofollow", -strlen(":nofollow")))) {
                        // line 91
                        echo "\t\t\t";
                        $context["nofollow"] = " rel=\"nofollow\"";
                        // line 92
                        echo "\t\t\t";
                        $context["image_link"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["image_link"]) ? $context["image_link"] : null), array(":nofollow" => "")));
                        // line 93
                        echo "\t\t";
                    }
                    // line 94
                    echo "
\t\t";
                    // line 96
                    echo "\t\t";
                    $context["link_href"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["image_link"]) ? $context["image_link"] : null), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files"))));
                    // line 97
                    echo "
\t\t";
                    // line 99
                    echo "\t\t";
                    if ((call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_target"]) ? $context["link_target"] : null))) || ((isset($context["link_target"]) ? $context["link_target"] : null) == "auto"))) {
                        // line 100
                        echo "\t\t\t";
                        if (((0 === strpos(call_user_func_array($this->env->getFilter('lower')->getCallable(), array($this->env, (isset($context["link_href"]) ? $context["link_href"] : null))), "http")) || call_user_func_array($this->env->getFunction('hasExtension')->getCallable(), array((isset($context["link_href"]) ? $context["link_href"] : null))))) {
                            // line 101
                            echo "\t\t\t\t";
                            $context["link_target"] = " target=\"_blank\"";
                            // line 102
                            echo "\t\t\t";
                        } else {
                            // line 103
                            echo "\t\t\t\t";
                            $context["link_target"] = "";
                            // line 104
                            echo "\t\t\t";
                        }
                        // line 105
                        echo "
\t\t";
                        // line 107
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "popup")) {
                        // line 108
                        echo "\t\t\t";
                        $context["link_target"] = ((((((" data-popup-window=\"" . call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"), array(" " => "-")))) . ",") . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "popup_width")) . ",") . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "popup_height")) . "\"");
                        // line 109
                        echo "
\t\t";
                        // line 111
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "_blank")) {
                        // line 112
                        echo "\t\t\t";
                        $context["link_target"] = " target=\"_blank\"";
                        // line 113
                        echo "
\t\t";
                        // line 115
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "x3_popup")) {
                        // line 116
                        echo "\t\t\t";
                        $context["link_target"] = " data-popup";
                        // line 117
                        echo "
\t\t";
                        // line 119
                        echo "\t\t";
                    } else {
                        // line 120
                        echo "\t\t\t";
                        $context["link_target"] = "";
                        // line 121
                        echo "\t\t";
                    }
                    // line 122
                    echo "
\t";
                    // line 124
                    echo "\t";
                } else {
                    // line 125
                    echo "\t\t";
                    $context["link_href"] = ((call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null))) . call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), array(" " => "_")))) . "/");
                    // line 126
                    echo "\t\t";
                    $context["link_target"] = "";
                    // line 127
                    echo "\t";
                }
                // line 128
                echo "
\t";
                // line 130
                echo "\t";
                $context["exif_array"] = array();
                // line 131
                echo "\t";
                // line 132
                echo "\t";
                $context["data_exif"] = "";
                // line 133
                echo "\t";
                $context["geo"] = "";
                // line 134
                echo "\t";
                $context["data_geo"] = "";
                // line 135
                echo "
\t";
                // line 137
                echo "\t";
                if ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif")) {
                    // line 138
                    echo "
\t\t";
                    // line 140
                    echo "\t\t";
                    if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["exif_items"]) ? $context["exif_items"] : null))) > 0)) {
                        // line 141
                        echo "\t\t\t";
                        // line 144
                        echo "\t\t\t";
                        // line 145
                        echo "\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["exif_items"]) ? $context["exif_items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
                            if ($this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), (isset($context["key"]) ? $context["key"] : null), array(), "array")) {
                                // line 146
                                echo "\t\t    ";
                                $context["exif_array"] = call_user_func_array($this->env->getFilter('merge')->getCallable(), array((isset($context["exif_array"]) ? $context["exif_array"] : null), array((isset($context["key"]) ? $context["key"] : null) => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), (isset($context["key"]) ? $context["key"] : null), array(), "array"))));
                                // line 147
                                echo "\t\t\t";
                            }
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 148
                        echo "\t\t\t";
                        if (call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["exif_array"]) ? $context["exif_array"] : null)))) {
                            $context["data_exif"] = ((" data-exif=\"" . call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('json_encode')->getCallable(), array((isset($context["exif_array"]) ? $context["exif_array"] : null))), "html_attr"))) . "\"");
                        }
                        // line 149
                        echo "\t\t";
                    }
                    // line 150
                    echo "
\t\t";
                    // line 152
                    echo "\t\t";
                    if (($this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude") && $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"))) {
                        // line 153
                        echo "\t\t\t";
                        $context["geo"] = (($this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude") . ",") . $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"));
                        // line 154
                        echo "\t\t\t";
                        $context["map_embed_src"] = (("https://www.google.com/maps/embed/v1/place?q=" . (isset($context["geo"]) ? $context["geo"] : null)) . "&amp;key=AIzaSyDRp6xla9SxUmTBu6l_kprhjjI9e5-EVZk");
                        // line 155
                        echo "\t\t\t";
                        $context["map_link_src"] = ("https://www.google.com/maps/search/?api=1&query=" . (isset($context["geo"]) ? $context["geo"] : null));
                        // line 156
                        echo "\t\t\t";
                        $context["map_embed_button_item"] = (((("<button data-href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-popup-href=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"button small button-map\" data-popup-class=\"x3-popup-iframe-full\" data-popup></button>");
                        // line 157
                        echo "\t\t\t";
                        $context["map_button_popup"] = (((("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-embed-modal=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"button small button-map\" target=\"_blank\"></a>");
                        // line 158
                        echo "\t\t\t";
                        $context["map_link_popup"] = (((("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" data-embed-modal=\"") . (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null)) . "\" class=\"link-map\" target=\"_blank\"></a>");
                        // line 159
                        echo "\t\t\t";
                        $context["map_button"] = (("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" class=\"button small button-map\" target=\"_blank\"></a>");
                        // line 160
                        echo "\t\t\t";
                        $context["map_link"] = (("<a href=\"" . (isset($context["map_link_src"]) ? $context["map_link_src"] : null)) . "\" class=\"link-map\" target=\"_blank\"></a>");
                        // line 161
                        echo "\t\t\t";
                        $context["data_geo"] = ((" data-geo=\"" . (isset($context["geo"]) ? $context["geo"] : null)) . "\"");
                        // line 162
                        echo "\t\t\t";
                        // line 165
                        echo "\t\t";
                    }
                    // line 166
                    echo "\t";
                }
                // line 167
                echo "
\t";
                // line 169
                echo "\t";
                $context["title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title_include"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files")))), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name")));
                // line 170
                echo "\t";
                if ((isset($context["geo"]) ? $context["geo"] : null)) {
                    $context["title"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["title"]) ? $context["title"] : null), array("{latitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude"), "{longitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"), "{map_embed_src}" => (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null), "{map_link_src}" => (isset($context["map_link_src"]) ? $context["map_link_src"] : null), "{map_button_popup}" => (isset($context["map_button_popup"]) ? $context["map_button_popup"] : null), "{map_link_popup}" => (isset($context["map_link_popup"]) ? $context["map_link_popup"] : null), "{map_button}" => (isset($context["map_button"]) ? $context["map_button"] : null), "{map_link}" => (isset($context["map_link"]) ? $context["map_link"] : null))));
                }
                // line 171
                echo "\t";
                $context["title_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["title"]) ? $context["title"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                // line 172
                echo "
\t";
                // line 174
                echo "\t";
                $context["image_description"] = call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description_include")));
                // line 175
                echo "\t";
                if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null)))) {
                    // line 176
                    echo "\t\t";
                    $context["description"] = "";
                    // line 177
                    echo "\t\t";
                    $context["description_pseudo"] = "";
                    // line 178
                    echo "\t";
                } else {
                    // line 179
                    echo "\t\t";
                    $context["description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files"))));
                    // line 180
                    echo "\t\t";
                    if ((isset($context["geo"]) ? $context["geo"] : null)) {
                        $context["description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["description"]) ? $context["description"] : null), array("{latitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "latitude"), "{longitude}" => $this->getAttribute($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"), "longitude"), "{map_embed_src}" => (isset($context["map_embed_src"]) ? $context["map_embed_src"] : null), "{map_link_src}" => (isset($context["map_link_src"]) ? $context["map_link_src"] : null), "{map_button_popup}" => (isset($context["map_button_popup"]) ? $context["map_button_popup"] : null), "{map_link_popup}" => (isset($context["map_link_popup"]) ? $context["map_link_popup"] : null), "{map_button}" => (isset($context["map_button"]) ? $context["map_button"] : null), "{map_link}" => (isset($context["map_link"]) ? $context["map_link"] : null))));
                    }
                    // line 181
                    echo "\t\t";
                    $context["description_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["description"]) ? $context["description"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                    // line 182
                    echo "\t";
                }
                // line 183
                echo "
\t";
                // line 185
                echo "\t";
                $context["date"] = $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "date");
                // line 186
                echo "\t";
                if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "date_format") == "timeago")) {
                    // line 187
                    echo "\t\t";
                    $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
                    // line 188
                    echo "\t\t";
                    $context["date_class"] = "date timeago";
                    // line 189
                    echo "\t";
                } else {
                    // line 190
                    echo "\t\t";
                    $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format"), "d F Y"))) : ("d F Y"))));
                    // line 191
                    echo "\t\t";
                    $context["date_class"] = "date";
                    // line 192
                    echo "\t";
                }
                // line 193
                echo "\t";
                $context["time_tag"] = (((((("<time itemprop=\"dateCreated\" datetime=\"" . call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"))) . "\" class=\"") . (isset($context["date_class"]) ? $context["date_class"] : null)) . "\">") . (isset($context["date_formatted"]) ? $context["date_formatted"] : null)) . "</time>");
                // line 194
                echo "
\t";
                // line 196
                echo "\t";
                $context["image_ratio"] = ((array_key_exists("crop_ratio", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["crop_ratio"]) ? $context["crop_ratio"] : null), (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") / $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")) * 100)))) : ((($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") / $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")) * 100)));
                // line 197
                echo "
\t";
                // line 199
                echo "\t";
                if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "tooltip"), "enabled")) {
                    // line 200
                    echo "\t\t";
                    $context["tooltip_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "tooltip"), "items"), ","));
                    // line 201
                    echo "\t\t";
                    ob_start();
                    // line 202
                    echo "\t\t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["tooltip_items"]) ? $context["tooltip_items"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                        // line 203
                        echo "\t\t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                            echo "<span class=\"title\">";
                            echo (isset($context["title"]) ? $context["title"] : null);
                            echo "</span>
\t\t\t";
                        } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                            // line 204
                            echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                            echo "
\t\t\t";
                        } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                            // line 205
                            echo "<span class=\"description\">";
                            echo (isset($context["description"]) ? $context["description"] : null);
                            echo "</span>";
                        }
                        // line 206
                        echo "\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 207
                    echo "\t\t";
                    $context["link_title_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 208
                    echo "\t\t";
                    $context["link_title_content"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["link_title_content"]) ? $context["link_title_content"] : null), "html"))));
                    // line 209
                    echo "\t\t";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_title_content"]) ? $context["link_title_content"] : null))))) {
                        ob_start();
                        echo " title=\"";
                        echo (isset($context["link_title_content"]) ? $context["link_title_content"] : null);
                        echo "\"";
                        $context["link_title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    }
                    // line 210
                    echo "\t";
                }
                // line 211
                echo "
\t";
                // line 213
                echo "\t";
                ob_start();
                // line 214
                echo "\t";
                if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "slideshow")) {
                    // line 215
                    echo "\t<figure>
\t\t\t<div class=\"image-container\" style=\"padding-bottom:";
                    // line 216
                    echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
                    echo "%;\">
\t\t\t\t<img data-src=\"";
                    // line 217
                    echo (isset($context["url_escaped"]) ? $context["url_escaped"] : null);
                    echo "\" data-width=\"";
                    echo $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width");
                    echo "\"";
                    echo (isset($context["data_crop"]) ? $context["data_crop"] : null);
                    echo " alt=\"";
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["title"]) ? $context["title"] : null))), "html"));
                    echo "\" itemprop=\"thumbnail\">
\t\t\t</div>

\t\t";
                    // line 221
                    echo "\t\t";
                    if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "caption"), "enabled")) {
                        // line 222
                        echo "
\t\t\t";
                        // line 224
                        echo "\t\t\t";
                        ob_start();
                        // line 225
                        echo "\t\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable(call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "caption"), "items"), ",")));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 226
                            echo "\t\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo "<span class=\"title\">";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</span>
\t\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 227
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "
\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "maplink") && (isset($context["geo"]) ? $context["geo"] : null))) {
                                // line 228
                                echo " ";
                                echo (isset($context["map_embed_button_item"]) ? $context["map_embed_button_item"] : null);
                                echo "
\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description_pseudo"]) ? $context["description_pseudo"] : null)))))) {
                                // line 229
                                echo "<span class=\"description\">";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</span>";
                            }
                            // line 230
                            echo "\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 231
                        echo "\t\t\t";
                        $context["figcaption_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 232
                        echo "\t\t\t";
                        $context["figcaption_content"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["figcaption_content"]) ? $context["figcaption_content"] : null)));
                        // line 233
                        echo "
\t\t\t";
                        // line 235
                        echo "\t\t\t";
                        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["figcaption_content"]) ? $context["figcaption_content"] : null))))) {
                            // line 236
                            echo "\t\t\t\t<figcaption itemprop=\"caption description\">";
                            echo (isset($context["figcaption_content"]) ? $context["figcaption_content"] : null);
                            echo "</figcaption>
\t\t\t";
                        }
                        // line 238
                        echo "
  \t";
                    }
                    // line 240
                    echo "\t</figure>
\t";
                }
                // line 242
                echo "\t";
                $context["figure"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 243
                echo "
\t";
                // line 245
                echo "\t";
                ob_start();
                // line 246
                echo "
\t\t";
                // line 247
                echo (isset($context["li_open"]) ? $context["li_open"] : null);
                echo "

\t\t";
                // line 250
                echo "\t\t";
                $context["anchor_class"] = "item img-link item-link";
                // line 251
                echo "\t\t";
                if (((($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "clickable") && $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled")) && call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_link"]) ? $context["image_link"] : null)))) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "slideshow"))) {
                    // line 252
                    echo "\t\t\t";
                    $context["anchor_class"] = ((isset($context["anchor_class"]) ? $context["anchor_class"] : null) . " x3-popup");
                    // line 253
                    echo "\t\t";
                }
                // line 254
                echo "
\t\t";
                // line 256
                echo "\t\t";
                if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
                    // line 257
                    echo "\t\t\t";
                    $context["anchor_class"] = ((isset($context["anchor_class"]) ? $context["anchor_class"] : null) . " row");
                    // line 258
                    echo "\t\t";
                }
                // line 259
                echo "
\t\t";
                // line 261
                echo "\t\t";
                $context["link_tag"] = (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "clickable")) ? ("a") : ("span"));
                // line 262
                echo "
\t\t";
                // line 264
                echo "\t\t";
                if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "plugins"), "panorama"), "enabled")) {
                    // line 265
                    echo "\t\t\t";
                    $context["data_pano"] = call_user_func_array($this->env->getFunction('pano_params')->getCallable(), array((isset($context["image"]) ? $context["image"] : null), (isset($context["assetspath"]) ? $context["assetspath"] : null)));
                    // line 266
                    echo "\t\t\t";
                    if ((0 === strpos((isset($context["data_pano"]) ? $context["data_pano"] : null), " data-panorama="))) {
                        $context["anchor_class"] = ((isset($context["anchor_class"]) ? $context["anchor_class"] : null) . " x3-panorama");
                    }
                    // line 267
                    echo "\t\t";
                }
                // line 268
                echo "
\t\t";
                // line 270
                echo "\t\t";
                $context["data_is_link"] = (((isset($context["image_link"]) ? $context["image_link"] : null)) ? (" data-is-link=\"true\"") : (""));
                // line 271
                echo "
\t\t";
                // line 273
                echo "\t\t<";
                echo (isset($context["link_tag"]) ? $context["link_tag"] : null);
                echo " class=\"";
                echo (isset($context["anchor_class"]) ? $context["anchor_class"] : null);
                echo "\"";
                echo (isset($context["data_exif"]) ? $context["data_exif"] : null);
                echo (isset($context["data_geo"]) ? $context["data_geo"] : null);
                echo " data-width=\"";
                echo $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width");
                echo "\" data-height=\"";
                echo $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height");
                echo "\" data-image=\"";
                echo (isset($context["url_escaped"]) ? $context["url_escaped"] : null);
                echo "\" data-title=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["title"]) ? $context["title"] : null), "html"));
                echo "\" data-description=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["description"]) ? $context["description"] : null), "html"));
                echo "\" data-date=\"";
                echo (isset($context["date_formatted"]) ? $context["date_formatted"] : null);
                echo "\"";
                echo (isset($context["data_is_link"]) ? $context["data_is_link"] : null);
                echo " href=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["link_href"]) ? $context["link_href"] : null)));
                echo "\"";
                echo (isset($context["link_target"]) ? $context["link_target"] : null);
                echo " id=\"image-";
                echo (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "id", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "id"), $this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index")))) : ($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index")));
                echo "\"";
                echo (isset($context["link_title"]) ? $context["link_title"] : null);
                echo " itemprop=\"associatedMedia\" itemscope itemtype=\"http://schema.org/ImageObject\"";
                echo (isset($context["nofollow"]) ? $context["nofollow"] : null);
                echo (isset($context["data_pano"]) ? $context["data_pano"] : null);
                echo ">

\t\t";
                // line 276
                echo "\t\t";
                if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "slideshow")) {
                    // line 277
                    echo "
\t\t\t";
                    // line 279
                    echo "\t\t\t";
                    if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
                        // line 280
                        echo "
\t\t\t\t";
                        // line 282
                        echo "\t\t\t\t";
                        if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "invert")) {
                            // line 283
                            echo "\t\t\t\t\t";
                            $context["text_align"] = "medium-text-left";
                            // line 284
                            echo "\t\t\t\t";
                        } elseif ((!twig_in_filter("text-right", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")) && !twig_in_filter("text-left", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
                            // line 285
                            echo "\t\t\t\t\t";
                            $context["text_align"] = "medium-text-right";
                            // line 286
                            echo "\t\t\t\t";
                        }
                        // line 287
                        echo "
\t\t\t\t";
                        // line 289
                        echo "\t\t\t\t<div class=\"medium-";
                        echo $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio");
                        echo " columns ";
                        echo (isset($context["push"]) ? $context["push"] : null);
                        echo " ";
                        echo (isset($context["text_align"]) ? $context["text_align"] : null);
                        echo "\">
\t\t\t\t\t";
                        // line 291
                        echo "\t\t\t\t\t";
                        if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["items"]) ? $context["items"] : null))) < 2)) {
                            $context["items"] = call_user_func_array($this->env->getFilter('merge')->getCallable(), array((isset($context["items"]) ? $context["items"] : null), array(0 => "title", 1 => "description")));
                        }
                        // line 292
                        echo "\t\t\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 293
                            echo "\t\t\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                // line 294
                                echo "\t\t\t\t\t\t\t<h2 class=\"title\" itemprop=\"caption\">";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</h2>
\t\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                                // line 296
                                echo "\t\t\t\t\t\t\t<p itemprop=\"description\">";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</p>
\t\t\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 298
                                echo "\t\t\t\t\t\t\t<h6 class=\"date\">";
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "</h6>
\t\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "maplink") && (isset($context["geo"]) ? $context["geo"] : null))) {
                                // line 300
                                echo "\t\t\t\t\t\t\t";
                                echo (isset($context["map_embed_button_item"]) ? $context["map_embed_button_item"] : null);
                                echo "
\t\t\t\t\t\t";
                            }
                            // line 302
                            echo "\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 303
                        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"medium-";
                        // line 305
                        echo (12 - $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio"));
                        echo " columns ";
                        echo (isset($context["pull"]) ? $context["pull"] : null);
                        echo "\">
\t\t\t\t\t";
                        // line 306
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t\t\t</div>

\t\t\t";
                        // line 310
                        echo "\t\t\t";
                    } elseif (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) {
                        // line 311
                        echo "\t\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 312
                            echo "\t\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                // line 313
                                echo "\t\t\t\t\t\t<h2 class=\"title\" itemprop=\"caption\">";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</h2>
\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                                // line 315
                                echo "\t\t\t\t\t\t<p itemprop=\"description\">";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</p>
\t\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 317
                                echo "\t\t\t\t\t\t<h6 class=\"date\">";
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "</h6>
\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "maplink") && (isset($context["geo"]) ? $context["geo"] : null))) {
                                // line 319
                                echo "\t\t\t\t\t\t";
                                echo (isset($context["map_embed_button_item"]) ? $context["map_embed_button_item"] : null);
                                echo "
\t\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "preview")) {
                                // line 321
                                echo "\t\t\t\t\t\t";
                                echo (isset($context["figure"]) ? $context["figure"] : null);
                                echo "
\t\t\t\t\t";
                            }
                            // line 323
                            echo "\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 324
                        echo "
\t\t\t";
                        // line 326
                        echo "\t\t\t";
                    } else {
                        // line 327
                        echo "\t\t\t\t";
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t\t";
                    }
                    // line 329
                    echo "
\t\t";
                }
                // line 331
                echo "
\t\t</";
                // line 332
                echo (isset($context["link_tag"]) ? $context["link_tag"] : null);
                echo ">

\t\t";
                // line 335
                echo "\t\t";
                if ((((!$this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "last")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") == "vertical")) && $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "vertical"), "horizontal_rule"))) {
                    // line 336
                    echo "\t\t\t<hr class=\"hr\">
\t\t";
                }
                // line 338
                echo "
\t\t";
                // line 339
                echo (isset($context["li_close"]) ? $context["li_close"] : null);
                echo "

\t";
                $context["item"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 342
                echo "
\t";
                // line 344
                echo "\t";
                if ((twig_in_filter("landscape", (isset($context["module_classes"]) ? $context["module_classes"] : null)) || twig_in_filter("portrait", (isset($context["module_classes"]) ? $context["module_classes"] : null)))) {
                    // line 345
                    echo "\t\t";
                    if ((twig_in_filter("landscape", (isset($context["module_classes"]) ? $context["module_classes"] : null)) && ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width") > $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height")))) {
                        // line 346
                        echo "\t\t\t";
                        echo (isset($context["item"]) ? $context["item"] : null);
                        echo "
\t\t";
                    } elseif ((twig_in_filter("portrait", (isset($context["module_classes"]) ? $context["module_classes"] : null)) && ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") > $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")))) {
                        // line 348
                        echo "\t\t\t";
                        echo (isset($context["item"]) ? $context["item"] : null);
                        echo "
\t\t";
                    }
                    // line 350
                    echo "\t";
                } else {
                    // line 351
                    echo "\t\t";
                    echo (isset($context["item"]) ? $context["item"] : null);
                    echo "
\t";
                }
                // line 353
                echo "
";
            }
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 356
        echo "
";
        // line 358
        echo (isset($context["ul_close"]) ? $context["ul_close"] : null);
        echo "

";
        // line 361
        if ((((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_videos"]) ? $context["gallery_videos"] : null))) > 0) && !twig_in_filter("hide-video", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes"))) && twig_in_filter("video-bottom", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
            // line 362
            echo "\t";
            if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null))) > 0)) {
                echo "<hr>";
            }
            // line 363
            echo "\t";
            $this->env->loadTemplate("partials/module.video.html")->display($context);
        }
    }

    public function getTemplateName()
    {
        return "partials/module.gallery.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1011 => 363,  1006 => 362,  1004 => 361,  999 => 358,  996 => 356,  974 => 351,  971 => 350,  965 => 348,  959 => 346,  956 => 345,  953 => 344,  950 => 342,  944 => 339,  937 => 336,  934 => 335,  929 => 332,  922 => 329,  916 => 327,  913 => 326,  910 => 324,  904 => 323,  898 => 321,  892 => 319,  886 => 317,  880 => 315,  874 => 313,  871 => 312,  866 => 311,  863 => 310,  857 => 306,  847 => 303,  841 => 302,  835 => 300,  829 => 298,  823 => 296,  817 => 294,  814 => 293,  809 => 292,  804 => 291,  792 => 287,  789 => 286,  786 => 285,  783 => 284,  774 => 280,  768 => 277,  765 => 276,  729 => 273,  720 => 268,  717 => 267,  712 => 266,  706 => 264,  703 => 262,  700 => 261,  697 => 259,  694 => 258,  691 => 257,  688 => 256,  685 => 254,  682 => 253,  679 => 252,  676 => 251,  673 => 250,  668 => 247,  665 => 246,  662 => 245,  659 => 243,  656 => 242,  648 => 238,  642 => 236,  639 => 235,  636 => 233,  633 => 232,  630 => 231,  624 => 230,  608 => 227,  600 => 226,  574 => 217,  564 => 214,  561 => 213,  558 => 211,  555 => 210,  546 => 209,  543 => 208,  540 => 207,  534 => 206,  529 => 205,  524 => 204,  511 => 202,  508 => 201,  505 => 200,  502 => 199,  499 => 197,  496 => 196,  493 => 194,  490 => 193,  487 => 192,  484 => 191,  481 => 190,  478 => 189,  475 => 188,  472 => 187,  469 => 186,  466 => 185,  463 => 183,  460 => 182,  457 => 181,  452 => 180,  449 => 179,  446 => 178,  443 => 177,  440 => 176,  437 => 175,  434 => 174,  431 => 172,  428 => 171,  423 => 170,  420 => 169,  417 => 167,  414 => 166,  411 => 165,  368 => 148,  350 => 144,  348 => 141,  345 => 140,  342 => 138,  336 => 135,  333 => 134,  330 => 133,  327 => 132,  313 => 126,  310 => 125,  307 => 124,  301 => 121,  295 => 119,  292 => 117,  289 => 116,  286 => 115,  283 => 113,  280 => 112,  277 => 111,  274 => 109,  271 => 108,  268 => 107,  265 => 105,  262 => 104,  259 => 103,  256 => 102,  247 => 99,  244 => 97,  241 => 96,  238 => 94,  235 => 93,  232 => 92,  229 => 91,  151 => 62,  139 => 58,  121 => 51,  118 => 50,  1002 => 316,  988 => 315,  983 => 313,  980 => 353,  976 => 310,  973 => 309,  967 => 304,  961 => 302,  958 => 301,  955 => 299,  949 => 298,  946 => 297,  941 => 338,  936 => 295,  931 => 294,  926 => 331,  921 => 292,  914 => 291,  909 => 290,  906 => 289,  900 => 285,  894 => 284,  891 => 283,  885 => 282,  882 => 281,  877 => 280,  872 => 279,  867 => 278,  862 => 277,  855 => 276,  851 => 305,  842 => 274,  839 => 272,  836 => 271,  833 => 270,  830 => 269,  827 => 268,  824 => 267,  821 => 265,  818 => 264,  813 => 261,  798 => 260,  795 => 289,  790 => 255,  787 => 254,  780 => 283,  777 => 282,  771 => 279,  766 => 250,  761 => 249,  753 => 248,  745 => 247,  739 => 246,  731 => 245,  726 => 271,  723 => 270,  721 => 242,  709 => 265,  705 => 238,  701 => 236,  698 => 235,  695 => 234,  689 => 232,  686 => 231,  683 => 230,  680 => 229,  672 => 227,  669 => 226,  666 => 225,  663 => 224,  655 => 222,  652 => 240,  649 => 220,  643 => 218,  640 => 217,  632 => 215,  629 => 214,  619 => 229,  616 => 211,  613 => 228,  610 => 208,  607 => 207,  604 => 206,  601 => 205,  598 => 204,  595 => 225,  592 => 224,  589 => 222,  586 => 221,  583 => 197,  578 => 196,  575 => 194,  570 => 216,  567 => 215,  531 => 190,  528 => 188,  525 => 187,  522 => 186,  519 => 185,  516 => 203,  513 => 183,  510 => 182,  506 => 180,  503 => 179,  500 => 178,  497 => 177,  494 => 175,  491 => 174,  488 => 173,  485 => 172,  482 => 171,  479 => 170,  476 => 169,  473 => 168,  470 => 167,  467 => 166,  464 => 165,  461 => 164,  459 => 163,  456 => 162,  453 => 161,  451 => 160,  448 => 159,  445 => 158,  442 => 156,  439 => 155,  436 => 154,  433 => 153,  430 => 151,  427 => 150,  424 => 149,  421 => 148,  418 => 147,  415 => 146,  412 => 145,  409 => 162,  406 => 161,  403 => 160,  400 => 159,  397 => 158,  394 => 157,  391 => 156,  388 => 155,  385 => 154,  382 => 153,  379 => 152,  367 => 125,  364 => 124,  361 => 147,  358 => 146,  355 => 120,  337 => 116,  325 => 131,  317 => 112,  304 => 122,  298 => 120,  290 => 108,  285 => 107,  282 => 106,  279 => 105,  276 => 104,  273 => 102,  264 => 99,  261 => 98,  258 => 97,  255 => 95,  252 => 94,  240 => 90,  237 => 88,  234 => 87,  231 => 86,  228 => 85,  217 => 85,  150 => 62,  141 => 57,  138 => 56,  135 => 55,  132 => 53,  129 => 52,  126 => 51,  123 => 50,  109 => 46,  97 => 40,  82 => 34,  72 => 28,  384 => 151,  378 => 149,  376 => 150,  373 => 149,  370 => 126,  363 => 139,  359 => 137,  352 => 145,  346 => 133,  343 => 118,  340 => 117,  334 => 128,  328 => 125,  322 => 130,  319 => 128,  316 => 127,  306 => 118,  287 => 112,  281 => 110,  249 => 93,  246 => 92,  193 => 72,  190 => 71,  187 => 70,  184 => 69,  181 => 68,  175 => 65,  172 => 64,  169 => 70,  166 => 68,  163 => 64,  160 => 62,  148 => 61,  145 => 60,  133 => 56,  111 => 43,  83 => 34,  174 => 73,  157 => 64,  154 => 63,  114 => 47,  86 => 35,  60 => 22,  48 => 16,  51 => 17,  42 => 14,  127 => 54,  124 => 52,  120 => 49,  117 => 48,  106 => 45,  103 => 44,  100 => 42,  93 => 37,  79 => 32,  76 => 31,  58 => 22,  45 => 15,  38 => 11,  90 => 43,  61 => 23,  56 => 20,  44 => 15,  36 => 11,  27 => 7,  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 137,  335 => 124,  331 => 115,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 111,  303 => 117,  300 => 116,  297 => 114,  291 => 105,  288 => 104,  284 => 111,  269 => 105,  266 => 103,  254 => 98,  251 => 88,  243 => 91,  239 => 91,  226 => 90,  223 => 88,  220 => 87,  214 => 84,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 70,  171 => 54,  168 => 53,  162 => 66,  159 => 65,  152 => 59,  146 => 46,  142 => 59,  136 => 57,  130 => 55,  115 => 48,  112 => 47,  69 => 27,  65 => 24,  53 => 18,  47 => 16,  32 => 9,  22 => 3,  108 => 47,  105 => 45,  101 => 41,  98 => 41,  95 => 39,  92 => 37,  88 => 36,  85 => 35,  81 => 34,  78 => 32,  74 => 29,  71 => 29,  67 => 24,  55 => 17,  52 => 19,  49 => 18,  40 => 12,  34 => 10,  31 => 9,  29 => 8,  26 => 6,  24 => 4,  21 => 2,  278 => 108,  275 => 96,  272 => 106,  270 => 101,  267 => 100,  263 => 98,  260 => 101,  257 => 100,  253 => 101,  250 => 100,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 85,  219 => 83,  216 => 82,  211 => 83,  208 => 82,  205 => 81,  202 => 80,  199 => 79,  196 => 77,  194 => 76,  191 => 74,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 59,  155 => 63,  137 => 54,  134 => 53,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 45,  110 => 48,  107 => 44,  102 => 43,  99 => 43,  96 => 42,  94 => 38,  91 => 37,  89 => 36,  87 => 35,  84 => 36,  80 => 33,  77 => 31,  73 => 29,  70 => 25,  68 => 27,  66 => 26,  64 => 25,  62 => 23,  59 => 22,  57 => 20,  54 => 19,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 7,  25 => 5,  23 => 3,  19 => 1,);
    }
}
