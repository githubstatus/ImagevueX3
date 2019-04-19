<?php

/* partials/module.folders.html */
class __TwigTemplate_131444024c759c6143dbbce07e5e79e89e66413bab58620f3bf871aa0ebd7938 extends Twig_Template
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
        $context["folders"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "folders");
        // line 7
        $context["items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "items"), ","));
        // line 8
        $context["limit"] = $this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "limit");
        // line 9
        if ((call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["limit"]) ? $context["limit"] : null))) || ((isset($context["limit"]) ? $context["limit"] : null) < 1))) {
            $context["limit"] = 99999;
        }
        // line 10
        echo "
";
        // line 12
        $context["folders_split_view"] = (($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "enabled") && ($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") != "columns"));
        // line 13
        if ((isset($context["folders_split_view"]) ? $context["folders_split_view"] : null)) {
            // line 14
            echo "\t";
            // line 15
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "invert")) {
                // line 16
                echo "\t\t";
                $context["push"] = ("medium-push-" . (12 - $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "ratio")));
                // line 17
                echo "\t\t";
                $context["pull"] = ("medium-pull-" . $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "ratio"));
                // line 18
                echo "\t";
            }
        }
        // line 20
        echo "
";
        // line 22
        if ((($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "crop"), "enabled") && ($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") != "justified")) && ($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") != "columns"))) {
            // line 23
            echo "\t";
            $context["crop_ratio"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "crop"), "crop"), 1, array(), "array") / $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "crop"), "crop"), 0, array(), "array")) * 100);
            // line 24
            echo "\t";
            $context["data_crop"] = ((((" data-crop=\"" . call_user_func_array($this->env->getFilter('round')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "crop"), "crop"), 0, array(), "array")))) . ":") . call_user_func_array($this->env->getFilter('round')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "crop"), "crop"), 1, array(), "array")))) . "\"");
        }
        // line 26
        echo "
";
        // line 28
        $context["children"] = call_user_func_array($this->env->getFunction('sortby')->getCallable(), array($this->getAttribute((isset($context["folder"]) ? $context["folder"] : null), "children"), $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "folders"), "sortby"), ((($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "folders"), "sort") == "desc")) ? (true) : (false))));
        // line 29
        echo "
";
        // line 31
        if (($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") == "grid")) {
            // line 32
            echo "
\t";
            // line 34
            echo "\t";
            if (($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "space") > (-1))) {
                // line 35
                echo "\t\t";
                $context["ul_style"] = ((" style=\"margin: 0 " . ((((isset($context["width"]) ? $context["width"] : null) == "wide")) ? (($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "space") / 2)) : (((-$this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "space")) / 4)))) . "px\"");
                // line 36
                echo "\t\t";
                $context["li_style"] = ((((" style=\"padding: 0 " . ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "space") / 2)) . "px ") . $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "space")) . "px\"");
                // line 37
                echo "\t";
            }
            // line 38
            echo "
\t";
            // line 40
            echo "\t";
            if ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "use_width")) {
                // line 41
                echo "\t\t";
                $context["ul_open"] = (("<ul class=\"items\"" . (isset($context["ul_style"]) ? $context["ul_style"] : null)) . ">");
                // line 42
                echo "
\t";
                // line 44
                echo "\t";
            } else {
                // line 45
                echo "\t\t";
                $context["block_grid"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "grid"), "columns"), array(" " => ""))), ","));
                // line 46
                echo "\t\t";
                // line 47
                echo "\t\t";
                $context["columns_max"] = call_user_func_array($this->env->getFunction('max')->getCallable(), array(call_user_func_array($this->env->getFunction('min')->getCallable(), array((isset($context["limit"]) ? $context["limit"] : null), call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["children"]) ? $context["children"] : null))))), 3));
                // line 48
                echo "\t\t";
                $context["small_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 2, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"))), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "1")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 49
                echo "\t\t";
                $context["medium_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array(call_user_func_array($this->env->getFilter('default')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 1, array(), "array"), $this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array")))) : ($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"))), "2")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 50
                echo "\t\t";
                $context["large_grid"] = call_user_func_array($this->env->getFunction('min')->getCallable(), array((($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["block_grid"]) ? $context["block_grid"] : null), 0, array(), "array"), "3"))) : ("3")), (isset($context["columns_max"]) ? $context["columns_max"] : null)));
                // line 51
                echo "\t\t";
                $context["ul_open"] = (((((((("<ul class=\"small-block-grid-" . (isset($context["small_grid"]) ? $context["small_grid"] : null)) . " medium-block-grid-") . (isset($context["medium_grid"]) ? $context["medium_grid"] : null)) . " large-block-grid-") . (isset($context["large_grid"]) ? $context["large_grid"] : null)) . " items\"") . (isset($context["ul_style"]) ? $context["ul_style"] : null)) . ">");
                // line 52
                echo "\t";
            }
            // line 53
            echo "
\t";
            // line 55
            echo "\t";
            $context["li_open"] = (("<li" . (isset($context["li_style"]) ? $context["li_style"] : null)) . ">");
            // line 56
            echo "\t";
            $context["li_close"] = "</li>";
            // line 57
            echo "\t";
            $context["ul_close"] = "</ul>";
        }
        // line 59
        echo "
";
        // line 61
        if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["children"]) ? $context["children"] : null))) > 0)) {
            // line 62
            echo "\t";
            echo (isset($context["ul_open"]) ? $context["ul_open"] : null);
            echo "
\t";
            // line 63
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["children"]) ? $context["children"] : null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 64
                echo "\t";
                if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0") < (isset($context["limit"]) ? $context["limit"] : null))) {
                    // line 65
                    echo "\t\t";
                    echo (isset($context["li_open"]) ? $context["li_open"] : null);
                    echo "

\t\t";
                    // line 68
                    echo "\t\t";
                    $context["title"] = $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "title");
                    // line 69
                    echo "\t\t";
                    $context["title_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["title"]) ? $context["title"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                    // line 70
                    echo "\t\t";
                    $context["label"] = $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "label");
                    // line 71
                    echo "\t\t";
                    $context["child_id"] = call_user_func_array($this->env->getFilter('attribute_friendly')->getCallable(), array((isset($context["label"]) ? $context["label"] : null)));
                    // line 72
                    echo "
\t\t";
                    // line 74
                    echo "\t\t";
                    $context["date"] = (($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "date", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "date"), $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "updated")))) : ($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "updated")));
                    // line 75
                    echo "\t\t";
                    if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "date_format") == "timeago")) {
                        // line 76
                        echo "\t\t\t";
                        $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"));
                        // line 77
                        echo "\t\t\t";
                        $context["date_class"] = "date timeago";
                        // line 78
                        echo "\t\t";
                    } else {
                        // line 79
                        echo "\t\t\t";
                        $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format"), "d F Y"))) : ("d F Y"))));
                        // line 80
                        echo "\t\t\t";
                        $context["date_class"] = "date";
                        // line 81
                        echo "\t\t";
                    }
                    // line 82
                    echo "\t\t";
                    $context["time_tag"] = (((((("<time itemprop=\"dateCreated\" datetime=\"" . call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"))) . "\" class=\"") . (isset($context["date_class"]) ? $context["date_class"] : null)) . "\">") . (isset($context["date_formatted"]) ? $context["date_formatted"] : null)) . "</time>");
                    // line 83
                    echo "
\t\t";
                    // line 84
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description"))))) {
                        // line 85
                        echo "\t\t\t";
                        $context["description"] = $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description");
                        // line 86
                        echo "\t\t\t";
                        $context["description_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["description"]) ? $context["description"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                        // line 87
                        echo "\t\t";
                    }
                    // line 88
                    echo "
\t\t";
                    // line 90
                    echo "\t\t";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "gallery"), "assets"))))) {
                        // line 91
                        echo "\t\t\t";
                        $context["amount"] = call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, $this->getAttribute(call_user_func_array($this->env->getFunction('get')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "gallery"), "assets"))), "images")));
                        // line 92
                        echo "\t\t";
                    } else {
                        // line 93
                        echo "\t\t\t";
                        $context["amount"] = call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "images")));
                        // line 94
                        echo "\t\t";
                    }
                    // line 95
                    echo "
\t\t";
                    // line 97
                    echo "\t\t";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "folders"), "assets"))))) {
                        // line 98
                        echo "\t\t\t";
                        $context["folders_amount"] = $this->getAttribute(call_user_func_array($this->env->getFunction('get')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "folders"), "assets"))), "children_count");
                        // line 99
                        echo "\t\t";
                    } else {
                        // line 100
                        echo "\t\t\t";
                        $context["folders_amount"] = $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children_count");
                        // line 101
                        echo "\t\t";
                    }
                    // line 102
                    echo "
\t\t";
                    // line 104
                    echo "\t\t";
                    if ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "tooltip"), "enabled")) {
                        // line 105
                        echo "\t\t\t";
                        $context["tooltip_items"] = call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "tooltip"), "items"), ","));
                        // line 106
                        echo "\t\t\t";
                        ob_start();
                        // line 107
                        echo "\t\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["tooltip_items"]) ? $context["tooltip_items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 108
                            echo "\t\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo "<span class=\"title\">";
                                echo (isset($context["title"]) ? $context["title"] : null);
                                echo "</span>
\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                                // line 109
                                echo "<span class=\"title\">";
                                echo (isset($context["label"]) ? $context["label"] : null);
                                echo "</span>
\t\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 110
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "
\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "amount") && ((isset($context["amount"]) ? $context["amount"] : null) > 0))) {
                                // line 111
                                echo "<span class=\"amount\">";
                                echo (isset($context["amount"]) ? $context["amount"] : null);
                                echo " ";
                                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["amount"]) ? $context["amount"] : null), "image", "images"));
                                echo "</span>
\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "folders_amount") && ((isset($context["folders_amount"]) ? $context["folders_amount"] : null) > 0))) {
                                // line 112
                                echo "<span class=\"folder_amount\">";
                                echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                                echo " ";
                                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["folders_amount"]) ? $context["folders_amount"] : null), "album", "albums"));
                                echo "</span>
\t\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description")))))) {
                                // line 113
                                echo "<span class=\"description\">";
                                echo (isset($context["description"]) ? $context["description"] : null);
                                echo "</span>
\t\t\t\t";
                            }
                            // line 115
                            echo "\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 116
                        echo "\t\t\t";
                        $context["link_title_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 117
                        echo "\t\t\t";
                        $context["link_title_content"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["link_title_content"]) ? $context["link_title_content"] : null), "html"))));
                        // line 118
                        echo "\t\t\t";
                        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_title_content"]) ? $context["link_title_content"] : null))))) {
                            ob_start();
                            echo "title=\"";
                            echo (isset($context["link_title_content"]) ? $context["link_title_content"] : null);
                            echo "\"";
                            $context["link_title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        }
                        // line 119
                        echo "\t\t";
                    }
                    // line 120
                    echo "
\t\t";
                    // line 122
                    echo "\t\t";
                    $context["link_target"] = "";
                    // line 123
                    echo "\t\t";
                    $context["link_class"] = "";
                    // line 124
                    echo "\t\t";
                    $context["data_popup"] = false;
                    // line 125
                    echo "\t\t";
                    $context["data_popup_content"] = false;
                    // line 126
                    echo "\t\t";
                    $context["data_popup_window"] = "";
                    // line 127
                    echo "\t\t";
                    $context["nofollow"] = "";
                    // line 128
                    echo "
\t\t";
                    // line 130
                    echo "\t\t";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "url"))))) {
                        // line 131
                        echo "
\t\t\t";
                        // line 133
                        echo "\t\t\t";
                        $context["link"] = call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "url")));
                        // line 134
                        echo "
\t\t\t";
                        // line 136
                        echo "\t\t\t";
                        if ((0 === substr_compare((isset($context["link"]) ? $context["link"] : null), ":nofollow", -strlen(":nofollow")))) {
                            // line 137
                            echo "\t\t\t\t";
                            $context["nofollow"] = " rel=\"nofollow\"";
                            // line 138
                            echo "\t\t\t\t";
                            $context["link"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["link"]) ? $context["link"] : null), array(":nofollow" => "")));
                            // line 139
                            echo "\t\t\t";
                        }
                        // line 140
                        echo "
\t\t\t";
                        // line 142
                        echo "\t\t\t";
                        $context["hasExtension"] = call_user_func_array($this->env->getFunction('hasExtension')->getCallable(), array((isset($context["link"]) ? $context["link"] : null)));
                        // line 143
                        echo "
\t\t\t";
                        // line 145
                        echo "\t\t\t";
                        if (((call_user_func_array($this->env->getFilter('first')->getCallable(), array($this->env, (isset($context["link"]) ? $context["link"] : null))) != "/") && !twig_in_filter("http", (isset($context["link"]) ? $context["link"] : null)))) {
                            // line 146
                            echo "\t\t\t\t";
                            if ((isset($context["hasExtension"]) ? $context["hasExtension"] : null)) {
                                // line 147
                                echo "\t\t\t\t\t";
                                $context["link"] = ((call_user_func_array($this->env->getFilter('setpath')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "file_path"), "./")), (isset($context["rootpath"]) ? $context["rootpath"] : null))) . "/") . (isset($context["link"]) ? $context["link"] : null));
                                // line 148
                                echo "\t\t\t\t";
                            } else {
                                // line 149
                                echo "\t\t\t\t\t";
                                $context["link"] = (call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null))) . (isset($context["link"]) ? $context["link"] : null));
                                // line 150
                                echo "\t\t\t\t";
                            }
                            // line 151
                            echo "
\t\t\t";
                            // line 153
                            echo "\t\t\t";
                        } elseif ((((call_user_func_array($this->env->getFilter('first')->getCallable(), array($this->env, (isset($context["link"]) ? $context["link"] : null))) == "/") && (call_user_func_array($this->env->getFilter('last')->getCallable(), array($this->env, (isset($context["link"]) ? $context["link"] : null))) != "/")) && (!(isset($context["hasExtension"]) ? $context["hasExtension"] : null)))) {
                            // line 154
                            echo "\t\t\t\t";
                            $context["link"] = ((isset($context["link"]) ? $context["link"] : null) . "/");
                            // line 155
                            echo "\t\t\t";
                        }
                        // line 156
                        echo "
\t\t\t";
                        // line 158
                        echo "\t\t\t";
                        if (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target") && ($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target") != "auto"))) {
                            // line 159
                            echo "\t\t\t\t";
                            if (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target") == "popup")) {
                                // line 160
                                echo "\t\t\t\t\t";
                                // line 161
                                echo "\t\t\t\t\t";
                                $context["data_popup_window"] = (((($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "slug") . ",") . (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link", array(), "any", false, true), "width", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link", array(), "any", false, true), "width"), "600"))) : ("600"))) . ",") . (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link", array(), "any", false, true), "height", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link", array(), "any", false, true), "height"), "500"))) : ("500")));
                                // line 162
                                echo "\t\t\t\t";
                            } elseif (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target") == "x3_popup")) {
                                // line 163
                                echo "\t\t\t\t\t";
                                // line 164
                                echo "\t\t\t\t\t";
                                $context["data_popup"] = true;
                                // line 165
                                echo "\t\t\t\t\t";
                                if ($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "content")) {
                                    // line 166
                                    echo "\t\t\t\t\t\t";
                                    $context["data_popup_content"] = true;
                                    // line 167
                                    echo "\t\t\t\t\t\t";
                                    $context["link"] = "#";
                                    // line 168
                                    echo "\t\t\t\t\t";
                                }
                                // line 169
                                echo "\t\t\t\t";
                            } else {
                                // line 170
                                echo "\t\t\t\t\t";
                                $context["link_target"] = $this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target");
                                // line 171
                                echo "\t\t\t\t";
                            }
                            // line 172
                            echo "\t\t\t";
                        } elseif ((twig_in_filter("http", (isset($context["link"]) ? $context["link"] : null)) || (isset($context["hasExtension"]) ? $context["hasExtension"] : null))) {
                            // line 173
                            echo "\t\t\t\t";
                            $context["link_target"] = "_blank";
                            // line 174
                            echo "\t\t\t";
                        }
                        // line 175
                        echo "
\t\t\t";
                        // line 177
                        echo "\t\t\t";
                        if ((isset($context["hasExtension"]) ? $context["hasExtension"] : null)) {
                            // line 178
                            echo "\t\t\t\t";
                            $context["link_class"] = ((isset($context["link_class"]) ? $context["link_class"] : null) . " no-ajax");
                            // line 179
                            echo "\t\t\t";
                        }
                        // line 180
                        echo "
\t\t";
                    } elseif (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "content") && ($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "target") == "x3_popup"))) {
                        // line 182
                        echo "\t\t\t";
                        $context["data_popup"] = true;
                        // line 183
                        echo "\t\t\t";
                        $context["data_popup_content"] = true;
                        // line 184
                        echo "\t\t\t";
                        $context["link"] = "#";
                        // line 185
                        echo "\t\t";
                    } else {
                        // line 186
                        echo "\t\t\t";
                        $context["link"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "permalink"), array(" " => "_"))), "html")), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
                        // line 187
                        echo "\t\t";
                    }
                    // line 188
                    echo "
\t\t";
                    // line 190
                    echo "\t\t";
                    ob_start();
                    echo "<a href=\"";
                    echo (isset($context["link"]) ? $context["link"] : null);
                    echo "\" class=\"item-link";
                    echo (isset($context["link_class"]) ? $context["link_class"] : null);
                    echo "\"";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["link_target"]) ? $context["link_target"] : null))))) {
                        echo " target=\"";
                        echo (isset($context["link_target"]) ? $context["link_target"] : null);
                        echo "\"";
                    }
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["data_popup_window"]) ? $context["data_popup_window"] : null))))) {
                        echo " data-popup-window=\"";
                        echo (isset($context["data_popup_window"]) ? $context["data_popup_window"] : null);
                        echo "\"";
                    }
                    if ((isset($context["data_popup"]) ? $context["data_popup"] : null)) {
                        echo " data-popup";
                    }
                    if ($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "popup_class")) {
                        echo " data-popup-class=\"";
                        echo $this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "popup_class");
                        echo "\"";
                    }
                    if ((isset($context["data_popup_content"]) ? $context["data_popup_content"] : null)) {
                        echo " data-popup-content=\"";
                        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "content"), "html"));
                        echo "\"";
                    }
                    echo " ";
                    echo (isset($context["link_title"]) ? $context["link_title"] : null);
                    echo (isset($context["nofollow"]) ? $context["nofollow"] : null);
                    echo ">";
                    $context["href_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 191
                    echo "
\t\t";
                    // line 193
                    echo "\t\t";
                    ob_start();
                    $this->env->loadTemplate("partials/preview-image.html")->display(array_merge($context, array("page" => (isset($context["child"]) ? $context["child"] : null))));
                    $context["preview_img"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 194
                    echo "
\t\t";
                    // line 196
                    echo "\t\t";
                    if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["preview_img"]) ? $context["preview_img"] : null)))) {
                        $context["preview_img"] = (isset($context["preview_image"]) ? $context["preview_image"] : null);
                    }
                    // line 197
                    echo "
\t\t";
                    // line 199
                    echo "\t\t";
                    $context["preview_img_url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_img"]) ? $context["preview_img"] : null), ".")));
                    // line 200
                    echo "
\t\t";
                    // line 202
                    echo "    ";
                    if (((isset($context["preview_img"]) ? $context["preview_img"] : null) == "./app/public/images/default.png")) {
                        // line 203
                        echo "    \t";
                        $context["imgInfo"] = array(0 => 1280, 1 => 1280);
                        // line 204
                        echo "    \t";
                        $context["image_ratio"] = 100;
                        // line 205
                        echo "    ";
                    } else {
                        // line 206
                        echo "\t\t\t";
                        $context["imgInfo"] = call_user_func_array($this->env->getFunction('getimginfo')->getCallable(), array((isset($context["preview_img"]) ? $context["preview_img"] : null)));
                        // line 207
                        echo "    \t";
                        $context["image_ratio"] = ((array_key_exists("crop_ratio", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["crop_ratio"]) ? $context["crop_ratio"] : null), (((($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array"), 3))) : (3)) / (($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array"), 2))) : (2))) * 100)))) : ((((($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array"), 3))) : (3)) / (($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array"), 2))) : (2))) * 100)));
                        // line 208
                        echo "    ";
                    }
                    // line 209
                    echo "
    ";
                    // line 211
                    echo "    ";
                    ob_start();
                    // line 212
                    echo "    \t<h2 id=\"title-";
                    echo (isset($context["child_id"]) ? $context["child_id"] : null);
                    echo "\" data-file=\"";
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_img"]) ? $context["preview_img"] : null)));
                    echo "\" class=\"title\">";
                    echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                    echo "</h2>
    ";
                    $context["title_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 214
                    echo "    ";
                    ob_start();
                    // line 215
                    echo "    \t<h2 id=\"title-";
                    echo (isset($context["child_id"]) ? $context["child_id"] : null);
                    echo "\" class=\"title\">";
                    echo (isset($context["label"]) ? $context["label"] : null);
                    echo "</h2>
    ";
                    $context["label_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 217
                    echo "    ";
                    ob_start();
                    // line 218
                    echo "    \t<h6 class=\"date\">";
                    echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                    echo "</h6>
    ";
                    $context["date_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 220
                    echo "    ";
                    ob_start();
                    // line 221
                    echo "    \t";
                    if (((isset($context["amount"]) ? $context["amount"] : null) > 0)) {
                        // line 222
                        echo "    \t<h6 class=\"amount\"><span>";
                        echo (isset($context["amount"]) ? $context["amount"] : null);
                        echo " ";
                        echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["amount"]) ? $context["amount"] : null), "image", "images"));
                        echo "</span></h6>
    \t";
                    }
                    // line 224
                    echo "    ";
                    $context["amount_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 225
                    echo "    ";
                    ob_start();
                    // line 226
                    echo "    \t";
                    if (((isset($context["folders_amount"]) ? $context["folders_amount"] : null) > 0)) {
                        // line 227
                        echo "    \t<h6 class=\"folder_amount\"><span>";
                        echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                        echo " ";
                        echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["folders_amount"]) ? $context["folders_amount"] : null), "album", "albums"));
                        echo "</span></h6>
    \t";
                    }
                    // line 229
                    echo "    ";
                    $context["folders_amount_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 230
                    echo "    ";
                    if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description"))))) {
                        // line 231
                        echo "      ";
                        ob_start();
                        // line 232
                        echo "      \t<p>";
                        echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                        echo "</p>
      ";
                        $context["description_tag"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 234
                        echo "    ";
                    }
                    // line 235
                    echo "    ";
                    ob_start();
                    // line 236
                    echo "    <figure>
\t\t\t<div class=\"img-link\">
\t\t\t\t<div class=\"image-container\" style=\"padding-bottom:";
                    // line 238
                    echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
                    echo "%;\">
        \t<img data-src=\"";
                    // line 239
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_img_url"]) ? $context["preview_img_url"] : null)));
                    echo "\" data-width=\"";
                    echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array");
                    echo "\"";
                    echo (isset($context["data_crop"]) ? $context["data_crop"] : null);
                    echo " alt=\"";
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["title"]) ? $context["title"] : null))), "html"));
                    echo "\">
        </div>

        ";
                    // line 242
                    if ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "caption"), "enabled")) {
                        // line 243
                        echo "        \t";
                        ob_start();
                        // line 244
                        echo "\t        \t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable(call_user_func_array($this->env->getFilter('split')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "caption"), "items"), ",")));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 245
                            echo "\t        \t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo "<span class=\"title\">";
                                echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                                echo "</span>
\t        \t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                                // line 246
                                echo "<span class=\"title\">";
                                echo (isset($context["label"]) ? $context["label"] : null);
                                echo "</span>
\t        \t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "amount") && ((isset($context["amount"]) ? $context["amount"] : null) > 0))) {
                                // line 247
                                echo "<span class=\"amount\">";
                                echo (isset($context["amount"]) ? $context["amount"] : null);
                                echo " ";
                                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["amount"]) ? $context["amount"] : null), "image", "images"));
                                echo "</span>
\t        \t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "folders_amount") && ((isset($context["folders_amount"]) ? $context["folders_amount"] : null) > 0))) {
                                // line 248
                                echo "<span class=\"folder_amount\">";
                                echo (isset($context["folders_amount"]) ? $context["folders_amount"] : null);
                                echo " ";
                                echo call_user_func_array($this->env->getFunction('pluralize')->getCallable(), array((isset($context["folders_amount"]) ? $context["folders_amount"] : null), "album", "albums"));
                                echo "</span>
\t        \t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 249
                                echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                                echo "
\t        \t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description")))))) {
                                // line 250
                                echo "<span class=\"description\">";
                                echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                                echo "</span>";
                            }
                            // line 251
                            echo "\t        \t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 252
                        echo "        \t";
                        $context["figcaption"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 253
                        echo "        ";
                        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["figcaption"]) ? $context["figcaption"] : null))))))) {
                            echo "<figcaption>";
                            echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["figcaption"]) ? $context["figcaption"] : null)));
                            echo "</figcaption>";
                        }
                        // line 254
                        echo "        ";
                    }
                    // line 255
                    echo "\t\t\t</div>
\t\t</figure>
\t\t";
                    $context["figure"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 258
                    echo "
\t\t";
                    // line 260
                    echo "\t\t<section data-width=\"";
                    echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 0, array(), "array");
                    echo "\" data-height=\"";
                    echo $this->getAttribute((isset($context["imgInfo"]) ? $context["imgInfo"] : null), 1, array(), "array");
                    echo "\" id=\"folder-";
                    echo (isset($context["child_id"]) ? $context["child_id"] : null);
                    echo "\" aria-labelledby=\"title-";
                    echo (isset($context["child_id"]) ? $context["child_id"] : null);
                    echo "\" class=\"item";
                    if ((isset($context["folders_split_view"]) ? $context["folders_split_view"] : null)) {
                        echo " row";
                    }
                    echo "\">
\t\t";
                    // line 261
                    echo (isset($context["href_tag"]) ? $context["href_tag"] : null);
                    echo "

\t\t";
                    // line 264
                    echo "\t\t";
                    if ((isset($context["folders_split_view"]) ? $context["folders_split_view"] : null)) {
                        // line 265
                        echo "
\t\t";
                        // line 267
                        echo "\t\t";
                        if ($this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "invert")) {
                            // line 268
                            echo "\t\t\t";
                            $context["text_align"] = "medium-text-left";
                            // line 269
                            echo "\t\t";
                        } elseif ((!twig_in_filter("text-right", $this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "classes")) && !twig_in_filter("text-left", $this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "classes")))) {
                            // line 270
                            echo "\t\t\t";
                            $context["text_align"] = "medium-text-right";
                            // line 271
                            echo "\t\t";
                        }
                        // line 272
                        echo "
\t\t";
                        // line 274
                        echo "\t\t<div class=\"medium-";
                        echo $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "ratio");
                        echo " columns ";
                        echo (isset($context["push"]) ? $context["push"] : null);
                        echo " ";
                        echo (isset($context["text_align"]) ? $context["text_align"] : null);
                        echo "\">
\t\t";
                        // line 275
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 276
                            echo "\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo (isset($context["title_tag"]) ? $context["title_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                                // line 277
                                echo (isset($context["label_tag"]) ? $context["label_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 278
                                echo (isset($context["date_tag"]) ? $context["date_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "amount")) {
                                // line 279
                                echo (isset($context["amount_tag"]) ? $context["amount_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "folders_amount")) {
                                // line 280
                                echo (isset($context["folders_amount_tag"]) ? $context["folders_amount_tag"] : null);
                                echo "
\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description")))))) {
                                // line 281
                                echo (isset($context["description_tag"]) ? $context["description_tag"] : null);
                            }
                            // line 282
                            echo "\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 283
                        echo "\t\t</div>
\t\t<div class=\"medium-";
                        // line 284
                        echo (12 - $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "split"), "ratio"));
                        echo " columns ";
                        echo (isset($context["pull"]) ? $context["pull"] : null);
                        echo "\">
\t\t\t";
                        // line 285
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t</div>

\t\t";
                        // line 289
                        echo "\t\t";
                    } elseif (($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") != "justified")) {
                        // line 290
                        echo "\t\t";
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
                        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                            // line 291
                            echo "\t\t\t";
                            if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                                echo (isset($context["title_tag"]) ? $context["title_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "label")) {
                                // line 292
                                echo (isset($context["label_tag"]) ? $context["label_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                                // line 293
                                echo (isset($context["date_tag"]) ? $context["date_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "amount")) {
                                // line 294
                                echo (isset($context["amount_tag"]) ? $context["amount_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "folders_amount")) {
                                // line 295
                                echo (isset($context["folders_amount_tag"]) ? $context["folders_amount_tag"] : null);
                                echo "
\t\t\t";
                            } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "description")))))) {
                                // line 296
                                echo (isset($context["description_tag"]) ? $context["description_tag"] : null);
                                echo "
\t\t\t";
                            } elseif (((isset($context["item"]) ? $context["item"] : null) == "preview")) {
                                // line 297
                                echo (isset($context["figure"]) ? $context["figure"] : null);
                            }
                            // line 298
                            echo "\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 299
                        echo "
\t\t";
                        // line 301
                        echo "\t\t";
                    } else {
                        // line 302
                        echo "\t\t\t";
                        echo (isset($context["figure"]) ? $context["figure"] : null);
                        echo "
\t\t";
                    }
                    // line 304
                    echo "
\t\t</a>
\t\t</section>

\t\t";
                    // line 309
                    echo "\t\t";
                    if (((((($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") == "vertical") && $this->getAttribute($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "vertical"), "horizontal_rule")) && (!$this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "last"))) && ($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index") < (isset($context["limit"]) ? $context["limit"] : null))) || ((isset($context["folders_split_view"]) ? $context["folders_split_view"] : null) && ($this->getAttribute((isset($context["folders"]) ? $context["folders"] : null), "layout") == "grid")))) {
                        // line 310
                        echo "\t\t<hr class=\"hr\">
\t\t";
                    }
                    // line 312
                    echo "
\t\t";
                    // line 313
                    echo (isset($context["li_close"]) ? $context["li_close"] : null);
                    echo "
\t";
                }
                // line 315
                echo "\t";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 316
            echo "\t";
            echo (isset($context["ul_close"]) ? $context["ul_close"] : null);
            echo "

";
        }
    }

    public function getTemplateName()
    {
        return "partials/module.folders.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1002 => 316,  988 => 315,  983 => 313,  980 => 312,  976 => 310,  973 => 309,  967 => 304,  961 => 302,  958 => 301,  955 => 299,  949 => 298,  946 => 297,  941 => 296,  936 => 295,  931 => 294,  926 => 293,  921 => 292,  914 => 291,  909 => 290,  906 => 289,  900 => 285,  894 => 284,  891 => 283,  885 => 282,  882 => 281,  877 => 280,  872 => 279,  867 => 278,  862 => 277,  855 => 276,  851 => 275,  842 => 274,  839 => 272,  836 => 271,  833 => 270,  830 => 269,  827 => 268,  824 => 267,  821 => 265,  818 => 264,  813 => 261,  798 => 260,  795 => 258,  790 => 255,  787 => 254,  780 => 253,  777 => 252,  771 => 251,  766 => 250,  761 => 249,  753 => 248,  745 => 247,  739 => 246,  731 => 245,  726 => 244,  723 => 243,  721 => 242,  709 => 239,  705 => 238,  701 => 236,  698 => 235,  695 => 234,  689 => 232,  686 => 231,  683 => 230,  680 => 229,  672 => 227,  669 => 226,  666 => 225,  663 => 224,  655 => 222,  652 => 221,  649 => 220,  643 => 218,  640 => 217,  632 => 215,  629 => 214,  619 => 212,  616 => 211,  613 => 209,  610 => 208,  607 => 207,  604 => 206,  601 => 205,  598 => 204,  595 => 203,  592 => 202,  589 => 200,  586 => 199,  583 => 197,  578 => 196,  575 => 194,  570 => 193,  567 => 191,  531 => 190,  528 => 188,  525 => 187,  522 => 186,  519 => 185,  516 => 184,  513 => 183,  510 => 182,  506 => 180,  503 => 179,  500 => 178,  497 => 177,  494 => 175,  491 => 174,  488 => 173,  485 => 172,  482 => 171,  479 => 170,  476 => 169,  473 => 168,  470 => 167,  467 => 166,  464 => 165,  461 => 164,  459 => 163,  456 => 162,  453 => 161,  451 => 160,  448 => 159,  445 => 158,  442 => 156,  439 => 155,  436 => 154,  433 => 153,  430 => 151,  427 => 150,  424 => 149,  421 => 148,  418 => 147,  415 => 146,  412 => 145,  409 => 143,  406 => 142,  403 => 140,  400 => 139,  397 => 138,  394 => 137,  391 => 136,  388 => 134,  385 => 133,  382 => 131,  379 => 130,  367 => 125,  364 => 124,  361 => 123,  358 => 122,  355 => 120,  337 => 116,  325 => 113,  317 => 112,  304 => 110,  298 => 109,  290 => 108,  285 => 107,  282 => 106,  279 => 105,  276 => 104,  273 => 102,  264 => 99,  261 => 98,  258 => 97,  255 => 95,  252 => 94,  240 => 90,  237 => 88,  234 => 87,  231 => 86,  228 => 85,  217 => 81,  150 => 62,  141 => 57,  138 => 56,  135 => 55,  132 => 53,  129 => 52,  126 => 51,  123 => 50,  109 => 45,  97 => 40,  82 => 34,  72 => 28,  384 => 151,  378 => 149,  376 => 128,  373 => 127,  370 => 126,  363 => 139,  359 => 137,  352 => 119,  346 => 133,  343 => 118,  340 => 117,  334 => 128,  328 => 125,  322 => 123,  319 => 122,  316 => 120,  306 => 118,  287 => 112,  281 => 110,  249 => 93,  246 => 92,  193 => 72,  190 => 71,  187 => 70,  184 => 69,  181 => 68,  175 => 65,  172 => 64,  169 => 66,  166 => 65,  163 => 64,  160 => 62,  148 => 61,  145 => 59,  133 => 51,  111 => 43,  83 => 34,  174 => 69,  157 => 61,  154 => 59,  114 => 47,  86 => 35,  60 => 22,  48 => 17,  51 => 19,  42 => 14,  127 => 51,  124 => 49,  120 => 49,  117 => 48,  106 => 44,  103 => 42,  100 => 41,  93 => 37,  79 => 32,  76 => 32,  58 => 22,  45 => 16,  38 => 12,  90 => 43,  61 => 24,  56 => 20,  44 => 15,  36 => 11,  27 => 7,  357 => 134,  354 => 133,  344 => 127,  341 => 126,  339 => 125,  335 => 124,  331 => 115,  329 => 122,  323 => 118,  320 => 116,  315 => 115,  312 => 114,  309 => 111,  303 => 117,  300 => 116,  297 => 114,  291 => 105,  288 => 104,  284 => 111,  269 => 105,  266 => 103,  254 => 98,  251 => 88,  243 => 91,  239 => 91,  226 => 84,  223 => 83,  220 => 82,  214 => 80,  201 => 61,  198 => 60,  195 => 59,  192 => 57,  185 => 56,  178 => 70,  171 => 54,  168 => 53,  162 => 50,  159 => 48,  152 => 59,  146 => 46,  142 => 54,  136 => 52,  130 => 49,  115 => 46,  112 => 46,  69 => 26,  65 => 24,  53 => 18,  47 => 16,  32 => 8,  22 => 3,  108 => 47,  105 => 45,  101 => 41,  98 => 40,  95 => 39,  92 => 37,  88 => 36,  85 => 35,  81 => 34,  78 => 27,  74 => 29,  71 => 29,  67 => 24,  55 => 17,  52 => 19,  49 => 18,  40 => 13,  34 => 9,  31 => 9,  29 => 8,  26 => 5,  24 => 4,  21 => 2,  278 => 108,  275 => 96,  272 => 106,  270 => 101,  267 => 100,  263 => 98,  260 => 101,  257 => 100,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 85,  219 => 83,  216 => 82,  211 => 79,  208 => 78,  205 => 77,  202 => 76,  199 => 75,  196 => 74,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 66,  167 => 64,  164 => 63,  161 => 60,  158 => 59,  155 => 63,  137 => 54,  134 => 53,  131 => 53,  128 => 52,  125 => 41,  122 => 39,  119 => 49,  116 => 48,  113 => 45,  110 => 48,  107 => 44,  102 => 43,  99 => 43,  96 => 42,  94 => 38,  91 => 37,  89 => 36,  87 => 35,  84 => 36,  80 => 32,  77 => 31,  73 => 30,  70 => 25,  68 => 27,  66 => 26,  64 => 26,  62 => 23,  59 => 23,  57 => 20,  54 => 19,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 10,  35 => 10,  33 => 9,  30 => 8,  28 => 6,  25 => 5,  23 => 3,  19 => 1,);
    }
}
