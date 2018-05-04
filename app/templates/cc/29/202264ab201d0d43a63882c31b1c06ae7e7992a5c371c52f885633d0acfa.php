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
        echo "<!doctype html>
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
        if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "cdn_core")) {
            // line 24
            echo "\t";
            $context["cdn_core"] = "https://d30xwzl2pxzvti.cloudfront.net";
        } else {
            // line 26
            echo "\t";
            $context["cdn_core"] = ((isset($context["rootpath"]) ? $context["rootpath"] : null) . "/app/public");
        }
        // line 28
        echo "
";
        // line 30
        $context["page_title"] = "";
        // line 31
        $context["page_description"] = "";
        // line 32
        echo "
";
        // line 34
        if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "template_name") == "file")) {
            // line 35
            echo "
\t";
            // line 37
            echo "\t";
            $context["dirname"] = call_user_func_array($this->env->getFilter('dirname')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink")));
            // line 38
            echo "\t";
            if ((((isset($context["dirname"]) ? $context["dirname"] : null) == ".") || call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null))))) {
                $context["dirname"] = "/";
            }
            // line 39
            echo "\t";
            $context["parent"] = call_user_func_array($this->env->getFunction('get')->getCallable(), array((isset($context["dirname"]) ? $context["dirname"] : null)));
            // line 40
            echo "\t";
            $context["parent_images"] = call_user_func_array($this->env->getFunction('sortby')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "images"), $this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sortby"), ((($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "sort") == "desc")) ? (true) : (false))));
            // line 41
            echo "
\t";
            // line 43
            echo "\t";
            $context["this"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "file_path");
            // line 44
            echo "\t";
            $context["image_description"] = "";
            // line 45
            echo "\t";
            $context["file_index"] = 0;
            // line 46
            echo "\t";
            $context["myimage"] = "";
            // line 47
            echo "\t";
            $context["next_image"] = false;
            // line 48
            echo "\t";
            $context["prev_image"] = false;
            // line 49
            echo "
\t";
            // line 51
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
                // line 52
                echo "
\t\t";
                // line 54
                echo "\t\t";
                if ((isset($context["get_next_image"]) ? $context["get_next_image"] : null)) {
                    // line 55
                    echo "\t\t\t";
                    $context["next_image"] = (isset($context["image"]) ? $context["image"] : null);
                    // line 56
                    echo "\t\t\t";
                    $context["get_next_image"] = false;
                    // line 57
                    echo "\t\t";
                }
                // line 58
                echo "
\t\t";
                // line 60
                echo "\t\t";
                if (((isset($context["this"]) ? $context["this"] : null) == $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "url"))) {
                    // line 61
                    echo "
\t\t\t";
                    // line 63
                    echo "\t\t\t";
                    if ($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")) {
                        // line 64
                        echo "\t\t\t\t";
                        echo call_user_func_array($this->env->getFunction('redirect')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "link")));
                        echo "

\t\t\t";
                        // line 67
                        echo "\t\t\t";
                    } else {
                        // line 68
                        echo "
\t\t\t\t";
                        // line 69
                        $context["folder_path"] = (((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "file_path"), "."))) . "/");
                        // line 70
                        echo "\t      ";
                        $context["page_title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "title_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))))), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name")));
                        // line 71
                        echo "\t\t\t\t";
                        $context["image_description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description"), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "gallery"), "image"), "description_include"), $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "name"))), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name"), "{path}" => (isset($context["folder_path"]) ? $context["folder_path"] : null), "{image_path}" => ((isset($context["folder_path"]) ? $context["folder_path"] : null) . $this->getAttribute((isset($context["image"]) ? $context["image"] : null), "file_name")))));
                        // line 72
                        echo "\t\t\t\t";
                        $context["page_description"] = ((array_key_exists("image_description", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), (((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))))) : ((((isset($context["page_title"]) ? $context["page_title"] : null) . " | ") . $this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "title"))));
                        // line 73
                        echo "\t\t\t\t";
                        $context["file_index"] = $this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index0");
                        // line 74
                        echo "
\t\t\t\t";
                        // line 76
                        echo "\t\t\t\t";
                        if ((isset($context["current_image"]) ? $context["current_image"] : null)) {
                            $context["prev_image"] = (isset($context["current_image"]) ? $context["current_image"] : null);
                        }
                        // line 77
                        echo "\t\t\t\t";
                        $context["get_next_image"] = true;
                        // line 78
                        echo "
\t\t\t\t";
                        // line 79
                        $context["myimage"] = (isset($context["image"]) ? $context["image"] : null);
                        // line 80
                        echo "\t\t\t";
                    }
                    // line 81
                    echo "\t\t";
                }
                // line 82
                echo "
\t\t";
                // line 84
                echo "\t\t";
                $context["current_image"] = (isset($context["image"]) ? $context["image"] : null);
                // line 85
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
            // line 86
            echo "
\t";
            // line 88
            echo "\t";
            $context["template"] = "partials/file.html";
        } else {
            // line 91
            echo "\t";
            $context["page_title"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "title");
            // line 92
            echo "\t";
            $context["page_description"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description");
            // line 93
            echo "\t";
            $context["template"] = "partials/content.html";
        }
        // line 95
        echo "
";
        // line 97
        $this->env->loadTemplate("partials/head.html")->display($context);
        // line 98
        $template = $this->env->resolveTemplate((isset($context["template"]) ? $context["template"] : null));
        $template->display($context);
        // line 99
        $this->env->loadTemplate("partials/footer.html")->display($context);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 101
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
        return array (  266 => 101,  263 => 99,  260 => 98,  258 => 97,  255 => 95,  251 => 93,  248 => 92,  245 => 91,  241 => 88,  238 => 86,  224 => 85,  221 => 84,  218 => 82,  215 => 81,  212 => 80,  210 => 79,  207 => 78,  204 => 77,  199 => 76,  196 => 74,  193 => 73,  190 => 72,  187 => 71,  184 => 70,  182 => 69,  179 => 68,  176 => 67,  170 => 64,  167 => 63,  164 => 61,  161 => 60,  158 => 58,  155 => 57,  152 => 56,  149 => 55,  146 => 54,  143 => 52,  125 => 51,  122 => 49,  119 => 48,  116 => 47,  113 => 46,  110 => 45,  107 => 44,  104 => 43,  101 => 41,  98 => 40,  95 => 39,  90 => 38,  87 => 37,  84 => 35,  82 => 34,  79 => 32,  77 => 31,  75 => 30,  72 => 28,  68 => 26,  64 => 24,  62 => 23,  59 => 21,  57 => 20,  54 => 18,  50 => 17,  46 => 16,  43 => 14,  41 => 13,  39 => 12,  37 => 11,  35 => 10,  33 => 9,  30 => 7,  28 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}
