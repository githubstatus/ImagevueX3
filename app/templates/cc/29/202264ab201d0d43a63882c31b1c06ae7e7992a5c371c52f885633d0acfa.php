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
        $context["local_js"] = ((((isset($context["local_public"]) ? $context["local_public"] : null) . "/js/") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version")) . "/x3.min.js");
        // line 25
        $context["local_css"] = ((((((isset($context["local_public"]) ? $context["local_public"] : null) . "/css/") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version")) . "/x3.skin.") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin")) . ".css");
        // line 26
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 27
            echo "\t";
            $context["core_js"] = (("https://cdn.jsdelivr.net/npm/x3.photo.gallery@" . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version")) . "/js/x3.min.js");
            // line 28
            echo "\t";
            $context["core_css"] = (((("https://cdn.jsdelivr.net/npm/x3.photo.gallery@" . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "stacey_version")) . "/css/x3.skin.") . $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "skin"), "skin")) . ".css");
            // line 29
            echo "\t";
        } else {
            // line 31
            echo "\t";
            // line 32
            echo "\t";
            // line 33
            echo "\t";
            $context["core_js"] = (isset($context["local_js"]) ? $context["local_js"] : null);
            // line 34
            echo "\t";
            $context["core_css"] = (isset($context["local_css"]) ? $context["local_css"] : null);
        }
        // line 36
        echo "
";
        // line 38
        $context["page_title"] = "";
        // line 39
        $context["page_description"] = "";
        // line 40
        echo "
";
        // line 42
        if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "template_name") == "file")) {
            // line 43
            echo "
\t";
            // line 45
            echo "\t";
            $context["dirname"] = call_user_func_array($this->env->getFilter('dirname')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink")));
            // line 46
            echo "\t";
            if ((((isset($context["dirname"]) ? $context["dirname"] : null) == ".") || call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null))))) {
                $context["dirname"] = "/";
            }
            // line 47
            echo "\t";
            $context["parent"] = call_user_func_array($this->env->getFunction('get')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null)));
            // line 48
            echo "\t";
            $context["parent_images"] = call_user_func_array($this->env->getFunction('sortby')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "images"), $this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sortby"), ((($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sort") == "desc")) ? (true) : (false))));
            // line 49
            echo "
\t";
            // line 51
            echo "\t";
            $context["this"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "file_path");
            // line 52
            echo "\t";
            $context["image_description"] = "";
            // line 53
            echo "\t";
            $context["file_index"] = 0;
            // line 54
            echo "\t";
            $context["myimage"] = "";
            // line 55
            echo "\t";
            $context["next_image"] = false;
            // line 56
            echo "\t";
            $context["prev_image"] = false;
            // line 57
            echo "
\t";
            // line 59
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
                // line 60
                echo "
\t\t";
                // line 62
                echo "\t\t";
                if ((isset($context["get_next_image"]) ? $context["get_next_image"] : null)) {
                    // line 63
                    echo "\t\t\t";
                    $context["next_image"] = (isset($context["image"]) ? $context["image"] : null);
                    // line 64
                    echo "\t\t\t";
                    $context["get_next_image"] = false;
                    // line 65
                    echo "\t\t";
                }
                // line 66
                echo "
\t\t";
                // line 68
                echo "\t\t";
                if (((isset($context["this"]) ? $context["this"] : null) == $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "url"))) {
                    // line 69
                    echo "
\t\t\t";
                    // line 71
                    echo "\t\t\t";
                    if ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")) {
                        // line 72
                        echo "\t\t\t\t";
                        echo call_user_func_array($this->env->getFunction('redirect')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")));
                        echo "

\t\t\t";
                        // line 75
                        echo "\t\t\t";
                    } else {
                        // line 76
                        echo "
\t\t\t\t";
                        // line 77
                        $context["folder_path"] = (((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "file_path"), "."))) . "/");
                        // line 78
                        echo "\t      ";
                        $context["page_title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))))), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name")));
                        // line 79
                        echo "\t\t\t\t";
                        $context["image_description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")))));
                        // line 80
                        echo "\t\t\t\t";
                        $context["page_description"] = ((array_key_exists("image_description", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), (((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))))) : ((((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))));
                        // line 81
                        echo "\t\t\t\t";
                        $context["file_index"] = $this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0");
                        // line 82
                        echo "
\t\t\t\t";
                        // line 84
                        echo "\t\t\t\t";
                        if ((isset($context["current_image"]) ? $context["current_image"] : null)) {
                            $context["prev_image"] = (isset($context["current_image"]) ? $context["current_image"] : null);
                        }
                        // line 85
                        echo "\t\t\t\t";
                        $context["get_next_image"] = true;
                        // line 86
                        echo "
\t\t\t\t";
                        // line 87
                        $context["myimage"] = (isset($context["image"]) ? $context["image"] : null);
                        // line 88
                        echo "\t\t\t";
                    }
                    // line 89
                    echo "\t\t";
                }
                // line 90
                echo "
\t\t";
                // line 92
                echo "\t\t";
                $context["current_image"] = (isset($context["image"]) ? $context["image"] : null);
                // line 93
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
            // line 94
            echo "
\t";
            // line 96
            echo "\t";
            $context["template"] = "partials/file.html";
        } else {
            // line 99
            echo "\t";
            $context["page_title"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "title");
            // line 100
            echo "\t";
            $context["page_description"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description");
            // line 101
            echo "\t";
            $context["template"] = "partials/content.html";
        }
        // line 103
        echo "
";
        // line 105
        $this->env->loadTemplate("partials/head.html")->display($context);
        // line 106
        $template = $this->env->resolveTemplate((isset($context["template"]) ? $context["template"] : null));
        $template->display($context);
        // line 107
        $this->env->loadTemplate("partials/footer.html")->display($context);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 109
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
        return array (  284 => 109,  281 => 107,  278 => 106,  276 => 105,  273 => 103,  269 => 101,  266 => 100,  263 => 99,  259 => 96,  256 => 94,  242 => 93,  239 => 92,  236 => 90,  233 => 89,  230 => 88,  228 => 87,  225 => 86,  222 => 85,  217 => 84,  214 => 82,  211 => 81,  208 => 80,  205 => 79,  202 => 78,  200 => 77,  197 => 76,  194 => 75,  188 => 72,  185 => 71,  182 => 69,  179 => 68,  176 => 66,  173 => 65,  170 => 64,  167 => 63,  164 => 62,  161 => 60,  143 => 59,  140 => 57,  137 => 56,  134 => 55,  131 => 54,  128 => 53,  125 => 52,  122 => 51,  119 => 49,  116 => 48,  113 => 47,  108 => 46,  105 => 45,  102 => 43,  100 => 42,  97 => 40,  95 => 39,  93 => 38,  90 => 36,  86 => 34,  83 => 33,  81 => 32,  79 => 31,  76 => 29,  73 => 28,  70 => 27,  68 => 26,  66 => 25,  64 => 24,  62 => 23,  59 => 21,  57 => 20,  54 => 18,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 11,  35 => 10,  33 => 9,  30 => 7,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
