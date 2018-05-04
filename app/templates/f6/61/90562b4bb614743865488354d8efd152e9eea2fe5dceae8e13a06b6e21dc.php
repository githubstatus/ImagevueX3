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
        echo "
";
        // line 13
        if ((((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_videos"]) ? $context["gallery_videos"] : null))) > 0) && !twig_in_filter("hide-video", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes"))) && !twig_in_filter("video-bottom", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
            // line 14
            echo "\t";
            $this->env->loadTemplate("partials/module.video.html")->display($context);
            // line 15
            echo "\t";
            if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null))) > 0)) {
                // line 16
                echo "\t\t<hr>
\t";
            }
        }
        // line 19
        echo "
";
        // line 21
        $context["nofollow"] = (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "image_noindex")) ? ("  rel=\"nofollow\"") : (""));
        // line 22
        echo "
";
        // line 24
        if ((($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "enabled") && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "columns"))) {
            // line 25
            echo "\t";
            $context["crop_ratio"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 1, array(), "array") / $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "crop"), "crop"), 0, array(), "array")) * 100);
        }
        // line 27
        echo "
";
        // line 29
        $context["gallery_split_view"] = (($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "enabled") && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "columns"));
        // line 30
        if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
            // line 31
            echo "\t";
            // line 32
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "invert")) {
                // line 33
                echo "\t\t";
                $context["push"] = ("medium-push-" . (12 - $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio")));
                // line 34
                echo "\t\t";
                $context["pull"] = ("medium-pull-" . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio"));
                // line 35
                echo "\t";
            }
        }
        // line 37
        echo "
";
        // line 39
        if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") == "grid")) {
            // line 40
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "use_width")) {
                // line 41
                echo "\t\t";
                $context["block_grid"] = array(0 => "3", 1 => "2", 2 => "1");
                // line 42
                echo "\t";
            } else {
                // line 43
                echo "\t\t";
                $context["block_grid"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "grid"), "columns"), ","));
                // line 44
                echo "\t";
            }
            // line 45
            echo "\t";
            $context["columns_limit"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array((isset($context["limit"]) ? $context["limit"] : null), call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null)))));
            // line 46
            echo "\t";
            $context["small_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"))), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "1")), (isset($context["columns_limit"]) ? $context["columns_limit"] : null)));
            // line 47
            echo "\t";
            $context["medium_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "2")), (isset($context["columns_limit"]) ? $context["columns_limit"] : null)));
            // line 48
            echo "\t";
            $context["large_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"), "3"))) : ("3")), (isset($context["columns_limit"]) ? $context["columns_limit"] : null)));
            // line 49
            echo "
\t";
            // line 50
            $context["ul_open"] = (((((("<ul class='small-block-grid-" . (isset($context["small_grid"]) ? $context["small_grid"] : null)) . " medium-block-grid-") . (isset($context["medium_grid"]) ? $context["medium_grid"] : null)) . " large-block-grid-") . (isset($context["large_grid"]) ? $context["large_grid"] : null)) . " items'>");
            // line 51
            echo "\t";
            $context["li_open"] = "<li>";
            // line 52
            echo "\t";
            $context["li_close"] = "</li>";
            // line 53
            echo "\t";
            $context["ul_close"] = "</ul>";
        }
        // line 55
        echo "
";
        // line 57
        echo (isset($context["ul_open"]) ? $context["ul_open"] : null);
        echo "

";
        // line 60
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
            // line 61
            echo "
";
            // line 63
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0") < (isset($context["limit"]) ? $context["limit"] : null))) {
                // line 64
                echo "
\t";
                // line 66
                echo "\t";
                $context["url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "file_path") . "/") . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), ".")));
                // line 67
                echo "\t";
                $context["image_link"] = (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link")))) : ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link")));
                // line 68
                echo "\t";
                $context["link_target"] = (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "target", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "target"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link_target")))) : ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "link_target")));
                // line 69
                echo "\t";
                $context["name_no_ext"] = call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")));
                // line 70
                echo "
\t";
                // line 72
                echo "\t";
                if ((isset($context["image_link"]) ? $context["image_link"] : null)) {
                    // line 73
                    echo "\t\t";
                    $context["link_href"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["image_link"]) ? $context["image_link"] : null), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files"))));
                    // line 74
                    echo "
\t\t";
                    // line 76
                    echo "\t\t";
                    if ((call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_target"]) ? $context["link_target"] : null))) || ((isset($context["link_target"]) ? $context["link_target"] : null) == "auto"))) {
                        // line 77
                        echo "\t\t\t";
                        if (((0 === strpos(call_user_func_array($this->env->getFilter('lower')->getCallable(), array($this->env, (isset($context["link_href"]) ? $context["link_href"] : null))), "http")) || call_user_func_array($this->env->getFunction('hasExtension')->getCallable(), array((isset($context["link_href"]) ? $context["link_href"] : null))))) {
                            // line 78
                            echo "\t\t\t\t";
                            $context["link_target"] = " target=_blank";
                            // line 79
                            echo "\t\t\t";
                        } else {
                            // line 80
                            echo "\t\t\t\t";
                            $context["link_target"] = "";
                            // line 81
                            echo "\t\t\t";
                        }
                        // line 82
                        echo "
\t\t";
                        // line 84
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "popup")) {
                        // line 85
                        echo "\t\t\t";
                        $context["link_target"] = ((((((" data-popup-window=\"" . call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"), array(" " => "-")))) . ",") . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "popup_width")) . ",") . $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "popup_height")) . "\"");
                        // line 86
                        echo "
\t\t";
                        // line 88
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "_blank")) {
                        // line 89
                        echo "\t\t\t";
                        $context["link_target"] = " target=_blank";
                        // line 90
                        echo "
\t\t";
                        // line 92
                        echo "\t\t";
                    } elseif (((isset($context["link_target"]) ? $context["link_target"] : null) == "x3_popup")) {
                        // line 93
                        echo "\t\t\t";
                        $context["link_target"] = " data-popup";
                        // line 94
                        echo "
\t\t";
                        // line 96
                        echo "\t\t";
                    } else {
                        // line 97
                        echo "\t\t\t";
                        $context["link_target"] = "";
                        // line 98
                        echo "\t\t";
                    }
                    // line 99
                    echo "
\t";
                    // line 101
                    echo "\t";
                } else {
                    // line 102
                    echo "\t\t";
                    $context["link_href"] = ((call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null))) . call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), array(" " => "_")))) . "/");
                    // line 103
                    echo "\t\t";
                    $context["link_target"] = "";
                    // line 104
                    echo "\t";
                }
                // line 105
                echo "
\t";
                // line 107
                echo "\t";
                $context["title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title_include"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files")))), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name")));
                // line 108
                echo "\t";
                $context["title_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["title"]) ? $context["title"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                // line 109
                echo "
\t";
                // line 111
                echo "\t";
                $context["image_description"] = call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description_include")));
                // line 112
                echo "\t";
                if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null)))) {
                    // line 113
                    echo "\t\t";
                    $context["description"] = "";
                    // line 114
                    echo "\t\t";
                    $context["description_pseudo"] = "";
                    // line 115
                    echo "\t";
                } else {
                    // line 116
                    echo "\t\t";
                    $context["description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => (isset($context["name_no_ext"]) ? $context["name_no_ext"] : null), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")), "{{files}}" => ((isset($context["assetspath"]) ? $context["assetspath"] : null) . "/content/custom/files"))));
                    // line 117
                    echo "\t\t";
                    $context["description_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["description"]) ? $context["description"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                    // line 118
                    echo "\t";
                }
                // line 119
                echo "
\t";
                // line 121
                echo "\t";
                $context["date"] = $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "date");
                // line 122
                echo "\t";
                if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "date_format") == "timeago")) {
                    // line 123
                    echo "\t\t";
                    $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
                    // line 124
                    echo "\t\t";
                    $context["date_class"] = "date timeago";
                    // line 125
                    echo "\t";
                } else {
                    // line 126
                    echo "\t\t";
                    $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format"), "d F Y"))) : ("d F Y"))));
                    // line 127
                    echo "\t\t";
                    $context["date_class"] = "date";
                    // line 128
                    echo "\t";
                }
                // line 129
                echo "\t";
                $context["time_tag"] = (((((("<time itemprop=dateCreated datetime=\"" . call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"))) . "\" class=\"") . (isset($context["date_class"]) ? $context["date_class"] : null)) . "\">") . (isset($context["date_formatted"]) ? $context["date_formatted"] : null)) . "</time>");
                // line 130
                echo "
\t";
                // line 132
                echo "\t";
                $context["image_ratio"] = ((array_key_exists("crop_ratio", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["crop_ratio"]) ? $context["crop_ratio"] : null), (($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") / $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")) * 100)))) : ((($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") / $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")) * 100)));
                // line 133
                echo "
\t";
                // line 135
                echo "\t";
                if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "tooltip"), "enabled")) {
                    // line 136
                    echo "\t\t";
                    $context["tooltip_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "tooltip"), "items"), ","));
                    // line 137
                    echo "\t\t";
                    ob_start();
                    // line 138
                    echo "\t\t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["tooltip_items"]) ? $context["tooltip_items"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                        // line 139
                        echo "\t\t\t";
                        if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                            echo "<span class=title>";
                            echo (isset($context["title"]) ? $context["title"] : null);
                            echo "</span>
\t\t\t";
                        } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                            // line 140
                            echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                            echo "
\t\t\t";
                        } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                            // line 141
                            echo "<span class=description>";
                            echo (isset($context["description"]) ? $context["description"] : null);
                            echo "</span>";
                        }
                        // line 142
                        echo "\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 143
                    echo "\t\t";
                    $context["link_title_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 144
                    echo "\t\t";
                    $context["link_title_content"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["link_title_content"]) ? $context["link_title_content"] : null), "html"))));
                    // line 145
                    echo "\t\t";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_title_content"]) ? $context["link_title_content"] : null))))) {
                        ob_start();
                        echo "title='";
                        echo (isset($context["link_title_content"]) ? $context["link_title_content"] : null);
                        echo "'";
                        $context["link_title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    }
                    // line 146
                    echo "\t";
                }
                // line 147
                echo "
\t";
                // line 149
                echo "\t";
                ob_start();
                // line 150
                echo "\t";
                if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "slideshow")) {
                    // line 151
                    echo "\t<figure>
\t\t\t<div class='image-container' style='padding-bottom:";
                    // line 152
                    echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
                    echo "%;'>
\t\t\t\t<img data-src='";
                    // line 153
                    echo (isset($context["url"]) ? $context["url"] : null);
                    echo "' alt='";
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["title"]) ? $context["title"] : null))), "html"));
                    echo "' itemprop='thumbnail'>
\t\t\t</div>

\t\t";
                    // line 157
                    echo "\t\t";
                    if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "caption"), "enabled")) {
                        // line 158
                        echo "
\t\t\t";
                        // line 160
                        echo "\t\t\t";
                        ob_start();
                        // line 161
                        echo "\t\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable(call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "caption"), "items"), ",")));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 162
                            echo "\t\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo "<span class='title'>";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</span>
\t\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 163
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "
\t\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description_pseudo"]) ? $context["description_pseudo"] : null)))))) {
                                // line 164
                                echo "<span class='description'>";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</span>";
                            }
                            // line 165
                            echo "\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 166
                        echo "\t\t\t";
                        $context["figcaption_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 167
                        echo "\t\t\t";
                        $context["figcaption_content"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["figcaption_content"]) ? $context["figcaption_content"] : null)));
                        // line 168
                        echo "
\t\t\t";
                        // line 170
                        echo "\t\t\t";
                        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["figcaption_content"]) ? $context["figcaption_content"] : null))))) {
                            // line 171
                            echo "\t\t\t\t<figcaption itemprop='caption description'>";
                            echo (isset($context["figcaption_content"]) ? $context["figcaption_content"] : null);
                            echo "</figcaption>
\t\t\t";
                        }
                        // line 173
                        echo "
  \t";
                    }
                    // line 175
                    echo "\t</figure>
\t";
                }
                // line 177
                echo "\t";
                $context["figure"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 178
                echo "
\t";
                // line 180
                echo "\t";
                ob_start();
                // line 181
                echo "
\t\t";
                // line 182
                echo (isset($context["li_open"]) ? $context["li_open"] : null);
                echo "

\t\t";
                // line 185
                echo "\t\t";
                $context["anchor_class"] = "item img-link item-link";
                // line 186
                echo "\t\t";
                if ((($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled") && call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_link"]) ? $context["image_link"] : null)))) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "slideshow"))) {
                    // line 187
                    echo "\t\t\t";
                    $context["anchor_class"] = ((isset($context["anchor_class"]) ? $context["anchor_class"] : null) . " x3-popup");
                    // line 188
                    echo "\t\t";
                }
                // line 189
                echo "\t\t";
                if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
                    // line 190
                    echo "\t\t\t";
                    $context["anchor_class"] = ((isset($context["anchor_class"]) ? $context["anchor_class"] : null) . " row");
                    // line 191
                    echo "\t\t";
                }
                // line 192
                echo "
\t\t";
                // line 194
                echo "\t\t";
                $context["exif"] = "";
                // line 195
                echo "\t\t";
                if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "caption"), "exif") && $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"))) {
                    // line 196
                    echo "\t\t\t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "exif"));
                    foreach ($context['_seq'] as $context["key"] => $context["val"]) {
                        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["val"]) ? $context["val"] : null))))) {
                            // line 197
                            echo "\t\t    ";
                            $context["exif"] = (((((isset($context["exif"]) ? $context["exif"] : null) . (isset($context["key"]) ? $context["key"] : null)) . ":") . (isset($context["val"]) ? $context["val"] : null)) . ";");
                            // line 198
                            echo "\t\t\t";
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 199
                    echo "\t\t\t";
                    if ((isset($context["exif"]) ? $context["exif"] : null)) {
                        // line 200
                        echo "\t\t\t\t";
                        $context["exif"] = (("data-exif=\"" . (isset($context["exif"]) ? $context["exif"] : null)) . "\"");
                        // line 201
                        echo "\t\t\t";
                    }
                    // line 202
                    echo "\t\t";
                }
                // line 203
                echo "


\t\t";
                // line 206
                $context["link_tag"] = (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "clickable")) ? ("a") : ("span"));
                // line 207
                echo "
\t\t";
                // line 209
                echo "\t\t<";
                echo (isset($context["link_tag"]) ? $context["link_tag"] : null);
                echo " class='";
                echo (isset($context["anchor_class"]) ? $context["anchor_class"] : null);
                echo "' ";
                echo (isset($context["exif"]) ? $context["exif"] : null);
                echo " data-options='w:";
                echo $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width");
                echo ";h:";
                echo $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height");
                echo "' data-image='";
                echo (isset($context["url"]) ? $context["url"] : null);
                echo "' data-title='";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["title"]) ? $context["title"] : null), "html"));
                echo "' data-description='";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["description"]) ? $context["description"] : null), "html"));
                echo "' data-date='";
                echo (isset($context["date_formatted"]) ? $context["date_formatted"] : null);
                echo "' href='";
                echo (isset($context["link_href"]) ? $context["link_href"] : null);
                echo "'";
                echo (isset($context["link_target"]) ? $context["link_target"] : null);
                echo " id='";
                echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"), array(" " => "-")));
                echo "' ";
                echo (isset($context["link_title"]) ? $context["link_title"] : null);
                echo " itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'";
                echo (isset($context["nofollow"]) ? $context["nofollow"] : null);
                echo ">

\t\t";
                // line 212
                echo "\t\t";
                if (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") == "slideshow")) {
                    // line 213
                    echo "\t\t\t<span itemprop='caption description' data-image='";
                    echo (isset($context["url"]) ? $context["url"] : null);
                    echo "'>
\t\t\t";
                    // line 214
                    if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))) {
                        // line 215
                        echo "\t\t\t\t";
                        echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                        echo "
\t\t\t";
                    } else {
                        // line 217
                        echo "\t\t\t\t<strong>";
                        echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                        echo "</strong>&nbsp; — &nbsp;";
                        echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                        echo "
\t\t\t";
                    }
                    // line 219
                    echo "\t\t\t</span>
\t\t";
                } else {
                    // line 221
                    echo "
\t\t";
                    // line 223
                    echo "\t\t";
                    if ((isset($context["gallery_split_view"]) ? $context["gallery_split_view"] : null)) {
                        // line 224
                        echo "
\t\t";
                        // line 226
                        echo "\t\t";
                        if ($this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "invert")) {
                            // line 227
                            echo "\t\t\t";
                            $context["text_align"] = "medium-text-left";
                            // line 228
                            echo "\t\t";
                        } elseif ((!twig_in_filter("text-right", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")) && !twig_in_filter("text-left", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
                            // line 229
                            echo "\t\t\t";
                            $context["text_align"] = "medium-text-right";
                            // line 230
                            echo "\t\t";
                        }
                        // line 231
                        echo "
\t\t";
                        // line 233
                        echo "\t\t<div class='medium-";
                        echo $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio");
                        echo " columns ";
                        echo (isset($context["push"]) ? $context["push"] : null);
                        echo " ";
                        echo (isset($context["text_align"]) ? $context["text_align"] : null);
                        echo "'>
\t\t\t";
                        // line 234
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 235
                            echo "\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                // line 236
                                echo "\t\t\t\t\t<h2 class='title' itemprop='caption'>";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</h2>
\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                                // line 238
                                echo "\t\t\t\t<p itemprop='description'>";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</p>
\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 240
                                echo "\t\t\t\t\t<h6 class=date>";
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "</h6>
\t\t\t\t";
                            }
                            // line 242
                            echo "\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 243
                        echo "
\t\t\t";
                        // line 245
                        echo "\t\t\t";
                        // line 255
                        echo "
\t\t</div>
\t\t<div class='medium-";
                        // line 257
                        echo (12 - $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "split"), "ratio"));
                        echo " columns ";
                        echo (isset($context["pull"]) ? $context["pull"] : null);
                        echo "'>
\t\t\t";
                        // line 258
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t</div>

\t\t";
                        // line 262
                        echo "\t\t";
                    } elseif (($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") != "justified")) {
                        // line 263
                        echo "\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 264
                            echo "\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                // line 265
                                echo "\t\t\t\t\t<h2 class='title' itemprop='caption'>";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</h2>
\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                                // line 267
                                echo "\t\t\t\t\t<p itemprop='description'>";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</p>
\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 269
                                echo "\t\t\t\t\t<h6 class=date>";
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "</h6>
\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "preview")) {
                                // line 271
                                echo "\t\t\t\t\t";
                                echo (isset($context["figure"]) ? $context["figure"] : null);
                                echo "
\t\t\t\t";
                            }
                            // line 273
                            echo "\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 274
                        echo "
\t\t";
                        // line 276
                        echo "\t\t";
                    } else {
                        // line 277
                        echo "\t\t\t";
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t";
                    }
                    // line 279
                    echo "
\t\t";
                }
                // line 281
                echo "
\t\t</";
                // line 282
                echo (isset($context["link_tag"]) ? $context["link_tag"] : null);
                echo ">

\t\t";
                // line 285
                echo "\t\t";
                if ((((!$this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "last")) && ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "layout") == "vertical")) && $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "vertical"), "horizontal_rule"))) {
                    // line 286
                    echo "\t\t\t<hr class=\"hr\">
\t\t";
                }
                // line 288
                echo "
\t\t";
                // line 289
                echo (isset($context["li_close"]) ? $context["li_close"] : null);
                echo "

\t";
                $context["item"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 292
                echo "
\t";
                // line 294
                echo "\t";
                if ((twig_in_filter("landscape", (isset($context["module_classes"]) ? $context["module_classes"] : null)) || twig_in_filter("portrait", (isset($context["module_classes"]) ? $context["module_classes"] : null)))) {
                    // line 295
                    echo "\t\t";
                    if ((twig_in_filter("landscape", (isset($context["module_classes"]) ? $context["module_classes"] : null)) && ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width") > $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height")))) {
                        // line 296
                        echo "\t\t\t";
                        echo (isset($context["item"]) ? $context["item"] : null);
                        echo "
\t\t";
                    } elseif ((twig_in_filter("portrait", (isset($context["module_classes"]) ? $context["module_classes"] : null)) && ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "height") > $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "width")))) {
                        // line 298
                        echo "\t\t\t";
                        echo (isset($context["item"]) ? $context["item"] : null);
                        echo "
\t\t";
                    }
                    // line 300
                    echo "\t";
                } else {
                    // line 301
                    echo "\t\t";
                    echo (isset($context["item"]) ? $context["item"] : null);
                    echo "
\t";
                }
                // line 303
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
        // line 306
        echo "
";
        // line 308
        echo (isset($context["ul_close"]) ? $context["ul_close"] : null);
        echo "

";
        // line 311
        if ((((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_videos"]) ? $context["gallery_videos"] : null))) > 0) && !twig_in_filter("hide-video", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes"))) && twig_in_filter("video-bottom", $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "classes")))) {
            // line 312
            echo "\t";
            if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_images"]) ? $context["gallery_images"] : null))) > 0)) {
                echo "<hr>";
            }
            // line 313
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
        return array (  860 => 313,  855 => 312,  853 => 311,  848 => 308,  829 => 303,  823 => 301,  820 => 300,  814 => 298,  808 => 296,  805 => 295,  802 => 294,  799 => 292,  793 => 289,  790 => 288,  786 => 286,  783 => 285,  771 => 279,  765 => 277,  762 => 276,  759 => 274,  753 => 273,  747 => 271,  741 => 269,  729 => 265,  726 => 264,  721 => 263,  718 => 262,  712 => 258,  702 => 255,  700 => 245,  697 => 243,  691 => 242,  685 => 240,  679 => 238,  673 => 236,  670 => 235,  657 => 233,  651 => 230,  648 => 229,  645 => 228,  642 => 227,  639 => 226,  636 => 224,  633 => 223,  630 => 221,  610 => 214,  605 => 213,  602 => 212,  570 => 209,  567 => 207,  560 => 203,  557 => 202,  554 => 201,  551 => 200,  548 => 199,  523 => 192,  520 => 191,  517 => 190,  514 => 189,  511 => 188,  508 => 187,  505 => 186,  502 => 185,  497 => 182,  494 => 181,  491 => 180,  488 => 178,  485 => 177,  481 => 175,  477 => 173,  471 => 171,  468 => 170,  465 => 168,  462 => 167,  459 => 166,  453 => 165,  443 => 163,  435 => 162,  413 => 153,  403 => 150,  400 => 149,  397 => 147,  394 => 146,  385 => 145,  382 => 144,  379 => 143,  368 => 141,  355 => 139,  350 => 138,  347 => 137,  344 => 136,  341 => 135,  338 => 133,  335 => 132,  332 => 130,  329 => 129,  326 => 128,  323 => 127,  320 => 126,  314 => 124,  311 => 123,  308 => 122,  305 => 121,  302 => 119,  299 => 118,  296 => 117,  293 => 116,  290 => 115,  287 => 114,  272 => 108,  197 => 77,  194 => 76,  191 => 74,  188 => 73,  185 => 72,  140 => 57,  32 => 9,  947 => 292,  933 => 291,  928 => 289,  925 => 288,  921 => 286,  918 => 285,  912 => 280,  906 => 278,  903 => 277,  900 => 275,  894 => 274,  891 => 273,  886 => 272,  881 => 271,  876 => 270,  871 => 269,  866 => 268,  859 => 267,  854 => 266,  851 => 265,  845 => 306,  839 => 260,  836 => 259,  830 => 258,  827 => 257,  822 => 256,  817 => 255,  812 => 254,  807 => 253,  800 => 252,  796 => 251,  787 => 250,  784 => 248,  781 => 247,  778 => 282,  775 => 281,  772 => 244,  769 => 243,  766 => 241,  763 => 240,  758 => 237,  743 => 236,  740 => 234,  735 => 267,  732 => 230,  725 => 229,  722 => 228,  716 => 227,  711 => 226,  706 => 257,  698 => 224,  690 => 223,  684 => 222,  676 => 221,  671 => 220,  668 => 219,  666 => 234,  658 => 215,  654 => 231,  650 => 213,  647 => 212,  644 => 211,  641 => 210,  635 => 208,  632 => 207,  629 => 206,  626 => 219,  618 => 217,  615 => 202,  612 => 215,  609 => 200,  601 => 198,  598 => 197,  595 => 196,  589 => 194,  586 => 193,  578 => 191,  575 => 190,  565 => 206,  562 => 187,  559 => 185,  556 => 184,  553 => 183,  550 => 182,  547 => 181,  544 => 180,  541 => 198,  538 => 197,  535 => 177,  532 => 196,  529 => 195,  526 => 194,  521 => 171,  518 => 169,  513 => 168,  510 => 166,  476 => 165,  473 => 163,  470 => 162,  467 => 161,  464 => 160,  461 => 159,  458 => 158,  455 => 157,  451 => 155,  448 => 164,  445 => 153,  442 => 152,  439 => 150,  436 => 149,  433 => 148,  430 => 161,  427 => 160,  424 => 158,  421 => 157,  418 => 143,  415 => 142,  412 => 141,  409 => 152,  406 => 151,  404 => 138,  401 => 137,  398 => 136,  396 => 135,  393 => 134,  390 => 133,  387 => 131,  384 => 130,  378 => 128,  372 => 125,  369 => 124,  366 => 123,  363 => 140,  357 => 120,  354 => 118,  351 => 117,  348 => 116,  345 => 115,  342 => 114,  339 => 113,  336 => 112,  333 => 111,  324 => 107,  312 => 105,  276 => 98,  262 => 96,  242 => 96,  239 => 94,  230 => 90,  209 => 81,  206 => 80,  203 => 79,  200 => 78,  195 => 71,  183 => 67,  180 => 66,  177 => 65,  171 => 63,  168 => 62,  165 => 63,  162 => 61,  159 => 58,  150 => 54,  123 => 50,  118 => 45,  97 => 36,  381 => 129,  375 => 126,  373 => 142,  370 => 145,  367 => 143,  360 => 121,  356 => 136,  349 => 134,  337 => 129,  331 => 127,  328 => 126,  319 => 122,  316 => 121,  313 => 119,  303 => 103,  300 => 116,  297 => 101,  294 => 113,  284 => 113,  281 => 112,  278 => 111,  275 => 109,  269 => 107,  257 => 102,  254 => 101,  246 => 96,  243 => 94,  240 => 93,  227 => 89,  223 => 84,  208 => 82,  205 => 81,  202 => 79,  181 => 72,  178 => 70,  175 => 69,  172 => 67,  169 => 66,  166 => 65,  160 => 62,  148 => 57,  145 => 60,  136 => 52,  133 => 53,  111 => 41,  83 => 34,  80 => 33,  47 => 16,  174 => 64,  157 => 61,  154 => 59,  114 => 45,  108 => 40,  99 => 43,  94 => 35,  91 => 34,  86 => 35,  73 => 30,  60 => 23,  48 => 17,  51 => 19,  42 => 13,  137 => 55,  134 => 54,  130 => 52,  127 => 51,  124 => 50,  120 => 47,  117 => 46,  115 => 43,  106 => 43,  103 => 38,  100 => 37,  93 => 39,  76 => 29,  66 => 27,  58 => 23,  38 => 11,  96 => 42,  88 => 33,  69 => 29,  56 => 20,  53 => 20,  44 => 14,  36 => 11,  27 => 6,  343 => 132,  340 => 131,  330 => 110,  327 => 108,  325 => 124,  321 => 111,  317 => 125,  315 => 106,  309 => 104,  306 => 103,  301 => 102,  298 => 101,  295 => 99,  289 => 100,  286 => 96,  283 => 94,  277 => 92,  274 => 91,  270 => 97,  264 => 85,  261 => 83,  252 => 80,  236 => 93,  233 => 92,  217 => 69,  201 => 57,  198 => 72,  192 => 70,  189 => 69,  186 => 68,  173 => 67,  163 => 64,  156 => 57,  147 => 53,  142 => 54,  139 => 37,  132 => 36,  126 => 35,  105 => 39,  102 => 28,  61 => 24,  45 => 16,  22 => 3,  92 => 37,  89 => 36,  85 => 32,  81 => 34,  78 => 23,  74 => 30,  71 => 29,  67 => 23,  55 => 18,  52 => 17,  49 => 16,  40 => 12,  34 => 10,  31 => 8,  29 => 7,  26 => 6,  24 => 4,  21 => 2,  266 => 105,  263 => 104,  260 => 103,  258 => 97,  255 => 81,  251 => 99,  248 => 98,  245 => 97,  241 => 88,  238 => 86,  224 => 88,  221 => 86,  218 => 85,  215 => 84,  212 => 82,  210 => 79,  207 => 78,  204 => 58,  199 => 78,  196 => 77,  193 => 76,  190 => 75,  187 => 74,  184 => 73,  182 => 70,  179 => 69,  176 => 68,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 58,  155 => 57,  152 => 59,  149 => 41,  146 => 54,  143 => 52,  125 => 50,  122 => 49,  119 => 48,  116 => 47,  113 => 46,  110 => 45,  107 => 44,  104 => 43,  101 => 42,  98 => 41,  95 => 40,  90 => 37,  87 => 37,  84 => 36,  82 => 31,  79 => 30,  77 => 32,  75 => 31,  72 => 25,  68 => 27,  64 => 25,  62 => 24,  59 => 22,  57 => 21,  54 => 19,  50 => 17,  46 => 15,  43 => 14,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 7,  25 => 5,  23 => 3,  19 => 1,);
    }
}
