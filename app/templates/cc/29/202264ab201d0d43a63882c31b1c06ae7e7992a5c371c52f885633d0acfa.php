<?php

/* page.html */
class __TwigTemplate_cc29202264ab201d0d43a63882c31b1c06ae7e7992a5c371c52f885633d0acfa extends Twig_Template
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
        echo "<!DOCTYPE html>
<!-- X3 website by www.photo.gallery -->
";
        // line 3
        ob_start();
        // line 4
        echo "
";
        // line 6
        $context["baseurl"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "base_url");
        // line 7
        echo "
";
        // line 9
        $context["absolutepath"] = call_user_func_array($this->env->getFilter('addprotocol')->getCallable(), array((isset($context["baseurl"]) ? $context["baseurl"] : null)));
        // line 10
        $context["rootpath"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["baseurl"]) ? $context["baseurl"] : null), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name") => "")));
        // line 11
        $context["assetspath"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_files"), "/")), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        // line 12
        $context["absolutepath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
        // line 13
        $context["rootpath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        // line 14
        echo "
";
        // line 16
        ob_start();
        $this->env->loadTemplate("partials/preview-image.html")->display($context);
        $context["preview_image"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 17
        if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null)))) {
            $context["preview_image"] = call_user_func_array($this->env->getFunction('get_default_preview_image')->getCallable(), array());
        }
        // line 18
        echo "
";
        // line 20
        $context["preview_image_full"] = (call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_files"), "/")), (isset($context["absolutepath"]) ? $context["absolutepath"] : null))) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), ".")));
        // line 21
        echo "
";
        // line 23
        $context["local_public"] = ((isset($context["rootpath"]) ? $context["rootpath"] : null) . "/app/public");
        // line 24
        $context["local_js"] = ((((isset($context["local_public"]) ? $context["local_public"] : null) . "/js/") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "x3_version")) . "/x3.min.js");
        // line 25
        $context["local_css"] = ((((((isset($context["local_public"]) ? $context["local_public"] : null) . "/css/") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "x3_version")) . "/x3.skin.") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin")) . ".css");
        // line 26
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 27
            echo "\t";
            $context["core_js"] = (("https://cdn.jsdelivr.net/npm/x3.photo.gallery@" . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "x3_version")) . "/js/x3.min.js");
            // line 28
            echo "\t";
            $context["core_css"] = (((("https://cdn.jsdelivr.net/npm/x3.photo.gallery@" . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "x3_version")) . "/css/x3.skin.") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin")) . ".css");
        } else {
            // line 30
            echo "\t";
            $context["core_js"] = (isset($context["local_js"]) ? $context["local_js"] : null);
            // line 31
            echo "\t";
            $context["core_css"] = (isset($context["local_css"]) ? $context["local_css"] : null);
        }
        // line 33
        echo "
";
        // line 35
        $context["page_title"] = "";
        // line 36
        $context["page_description"] = "";
        // line 37
        echo "
";
        // line 39
        if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "template_name") == "file")) {
            // line 40
            echo "
\t";
            // line 42
            echo "\t";
            $context["dirname"] = call_user_func_array($this->env->getFilter('dirname')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink")));
            // line 43
            echo "\t";
            if ((((isset($context["dirname"]) ? $context["dirname"] : null) == ".") || call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null))))) {
                $context["dirname"] = "/";
            }
            // line 44
            echo "\t";
            $context["parent"] = call_user_func_array($this->env->getFunction('get')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null)));
            // line 45
            echo "\t";
            $context["parent_images"] = call_user_func_array($this->env->getFunction('sortby')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "images"), $this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sortby"), ((($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sort") == "desc")) ? (true) : (false))));
            // line 46
            echo "
\t";
            // line 48
            echo "\t";
            $context["this"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "file_path");
            // line 49
            echo "\t";
            $context["image_description"] = "";
            // line 50
            echo "\t";
            $context["file_index"] = 0;
            // line 51
            echo "\t";
            $context["myimage"] = "";
            // line 52
            echo "\t";
            $context["next_image"] = false;
            // line 53
            echo "\t";
            $context["prev_image"] = false;
            // line 54
            echo "
\t";
            // line 56
            echo "\t";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["parent_images"]) ? $context["parent_images"] : null));
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
                // line 57
                echo "
\t\t";
                // line 59
                echo "\t\t";
                if ((isset($context["get_next_image"]) ? $context["get_next_image"] : null)) {
                    // line 60
                    echo "\t\t\t";
                    $context["next_image"] = (isset($context["image"]) ? $context["image"] : null);
                    // line 61
                    echo "\t\t\t";
                    $context["get_next_image"] = false;
                    // line 62
                    echo "\t\t";
                }
                // line 63
                echo "
\t\t";
                // line 65
                echo "\t\t";
                if (((isset($context["this"]) ? $context["this"] : null) == $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "url"))) {
                    // line 66
                    echo "
\t\t\t";
                    // line 68
                    echo "\t\t\t";
                    if ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")) {
                        // line 69
                        echo "\t\t\t\t";
                        echo call_user_func_array($this->env->getFunction('redirect')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")));
                        echo "

\t\t\t";
                        // line 72
                        echo "\t\t\t";
                    } else {
                        // line 73
                        echo "
\t\t\t\t";
                        // line 74
                        $context["folder_path"] = (((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "file_path"), "."))) . "/");
                        // line 75
                        echo "\t      ";
                        $context["page_title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))))), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name")));
                        // line 76
                        echo "\t\t\t\t";
                        $context["image_description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")))));
                        // line 77
                        echo "\t\t\t\t";
                        $context["page_description"] = ((array_key_exists("image_description", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), (((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))))) : ((((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))));
                        // line 78
                        echo "\t\t\t\t";
                        $context["file_index"] = $this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0");
                        // line 79
                        echo "
\t\t\t\t";
                        // line 81
                        echo "\t\t\t\t";
                        if ((isset($context["current_image"]) ? $context["current_image"] : null)) {
                            $context["prev_image"] = (isset($context["current_image"]) ? $context["current_image"] : null);
                        }
                        // line 82
                        echo "\t\t\t\t";
                        $context["get_next_image"] = true;
                        // line 83
                        echo "
\t\t\t\t";
                        // line 84
                        $context["myimage"] = (isset($context["image"]) ? $context["image"] : null);
                        // line 85
                        echo "\t\t\t";
                    }
                    // line 86
                    echo "\t\t";
                }
                // line 87
                echo "
\t\t";
                // line 89
                echo "\t\t";
                $context["current_image"] = (isset($context["image"]) ? $context["image"] : null);
                // line 90
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 91
            echo "
\t";
            // line 93
            echo "\t";
            $context["template"] = "partials/file.html";
        } else {
            // line 96
            echo "\t";
            $context["page_title"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "title");
            // line 97
            echo "\t";
            $context["page_description"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description");
            // line 98
            echo "\t";
            $context["template"] = "partials/content.html";
        }
        // line 100
        echo "
";
        // line 102
        $this->env->loadTemplate("partials/head.html")->display($context);
        // line 103
        $template = $this->env->resolveTemplate((isset($context["template"]) ? $context["template"] : null));
        $template->display($context);
        // line 104
        $this->env->loadTemplate("partials/footer.html")->display($context);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 106
        echo "
<!-- X3 website by www.photo.gallery -->";
    }

    public function getTemplateName()
    {
        return "page.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  278 => 106,  275 => 104,  272 => 103,  270 => 102,  267 => 100,  263 => 98,  260 => 97,  257 => 96,  253 => 93,  250 => 91,  236 => 90,  233 => 89,  230 => 87,  227 => 86,  224 => 85,  222 => 84,  219 => 83,  216 => 82,  211 => 81,  208 => 79,  205 => 78,  202 => 77,  199 => 76,  196 => 75,  194 => 74,  191 => 73,  188 => 72,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 63,  167 => 62,  164 => 61,  161 => 60,  158 => 59,  155 => 57,  137 => 56,  134 => 54,  131 => 53,  128 => 52,  125 => 51,  122 => 50,  119 => 49,  116 => 48,  113 => 46,  110 => 45,  107 => 44,  102 => 43,  99 => 42,  96 => 40,  94 => 39,  91 => 37,  89 => 36,  87 => 35,  84 => 33,  80 => 31,  77 => 30,  73 => 28,  70 => 27,  68 => 26,  66 => 25,  64 => 24,  62 => 23,  59 => 21,  57 => 20,  54 => 18,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 11,  35 => 10,  33 => 9,  30 => 7,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
