<?php

/* partials/module.video.html */
class __TwigTemplate_d004bd64c82959c74ad96030eed1b38adb44f11c884c77d15a0c11fcdf6d7e58 extends Twig_Template
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
<section class=\"x3-video-container\">

";
        // line 7
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["gallery_videos"]) ? $context["gallery_videos"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
            // line 8
            echo "
\t";
            // line 10
            echo "\t";
            $context["title"] = call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array(call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["video"]) ? $context["video"] : null), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "title_include"))), "<a><span><em><i><b><strong><small><s><mark>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["video"]) ? $context["video"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["video"]) ? $context["video"] : null), "file_name")))), $this->getAttribute((isset($context["video"]) ? $context["video"] : null), "name")));
            // line 11
            echo "\t";
            $context["title_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["title"]) ? $context["title"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
            // line 12
            echo "
\t";
            // line 14
            echo "\t";
            $context["image_description"] = call_user_func_array($this->env->getFunction('getDefault')->getCallable(), array($this->getAttribute((isset($context["video"]) ? $context["video"] : null), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description"), $this->getAttribute($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "image"), "description_include")));
            // line 15
            echo "\t";
            if (call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null)))) {
                // line 16
                echo "\t\t";
                $context["description"] = "";
                // line 17
                echo "\t\t";
                $context["description_pseudo"] = "";
                // line 18
                echo "\t";
            } else {
                // line 19
                echo "\t\t";
                $context["description"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null), "<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>")), array("{file_name}" => call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["video"]) ? $context["video"] : null), "file_name"))), "{file_name_ext}" => $this->getAttribute((isset($context["video"]) ? $context["video"] : null), "file_name"))));
                // line 20
                echo "\t\t";
                $context["description_pseudo"] = call_user_func_array($this->env->getFilter('replace')->getCallable(), array((isset($context["description"]) ? $context["description"] : null), array("<a" => "<span", "</a>" => "</span>", " href=" => " data-href=", " target=" => " data-target=")));
                // line 21
                echo "\t";
            }
            // line 22
            echo "
\t";
            // line 24
            echo "\t";
            $context["date"] = $this->getAttribute((isset($context["video"]) ? $context["video"] : null), "date");
            // line 25
            echo "\t";
            if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "date_format") == "timeago")) {
                // line 26
                echo "\t\t";
                $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
                // line 27
                echo "\t\t";
                $context["date_class"] = "date timeago";
                // line 28
                echo "\t";
            } else {
                // line 29
                echo "\t\t";
                $context["date_formatted"] = call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings", array(), "any", false, true), "date_format"), "d F Y"))) : ("d F Y"))));
                // line 30
                echo "\t\t";
                $context["date_class"] = "date";
                // line 31
                echo "\t";
            }
            // line 32
            echo "\t";
            $context["time_tag"] = (((((("<time itemprop=\"dateCreated\" datetime=\"" . call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"))) . "\" class=\"") . (isset($context["date_class"]) ? $context["date_class"] : null)) . "\">") . (isset($context["date_formatted"]) ? $context["date_formatted"] : null)) . "</time>");
            // line 33
            echo "
\t";
            // line 35
            echo "\t<div class=\"x3-video\">

\t";
            // line 38
            echo "\t";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 39
                echo "\t\t";
                if (((isset($context["item"]) ? $context["item"] : null) == "title")) {
                    // line 40
                    echo "\t\t\t<h2 class=\"title\" itemprop=\"caption\">";
                    echo (isset($context["title_pseudo"]) ? $context["title_pseudo"] : null);
                    echo "</h2>
\t\t";
                } elseif ((((isset($context["item"]) ? $context["item"] : null) == "description") && (!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["description"]) ? $context["description"] : null)))))) {
                    // line 42
                    echo "\t\t<p itemprop=\"description\">";
                    echo (isset($context["description_pseudo"]) ? $context["description_pseudo"] : null);
                    echo "</p>
\t\t";
                } elseif (((isset($context["item"]) ? $context["item"] : null) == "date")) {
                    // line 44
                    echo "\t\t\t<h6 class=\"date\">";
                    echo (isset($context["time_tag"]) ? $context["time_tag"] : null);
                    echo "</h6>
\t\t";
                } elseif (((isset($context["item"]) ? $context["item"] : null) == "preview")) {
                    // line 46
                    echo "\t\t\t<video width=\"100%\" preload=\"metadata\" class=\"x3-style-frame\" controls";
                    if ($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "settings"), "prevent_context")) {
                        echo " controlsList=\"nodownload\"";
                    }
                    echo ">
\t\t\t\t<source src=\"";
                    // line 47
                    echo ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "file_path") . "/") . $this->getAttribute((isset($context["video"]) ? $context["video"] : null), "file_name")), ".")));
                    echo "\" type=\"video/mp4\">
\t\t\t</video>
\t\t";
                }
                // line 50
                echo "\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "
\t";
            // line 53
            echo "\t</div>

\t";
            // line 56
            echo "\t";
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index") < call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["gallery_videos"]) ? $context["gallery_videos"] : null))))) {
                // line 57
                echo "\t\t<hr>
\t";
            }
            // line 59
            echo "
";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['video'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "
</section>";
    }

    public function getTemplateName()
    {
        return "partials/module.video.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  191 => 62,  176 => 59,  172 => 57,  169 => 56,  165 => 53,  162 => 51,  156 => 50,  150 => 47,  143 => 46,  137 => 44,  131 => 42,  125 => 40,  122 => 39,  117 => 38,  113 => 35,  110 => 33,  107 => 32,  104 => 31,  101 => 30,  98 => 29,  95 => 28,  92 => 27,  89 => 26,  86 => 25,  83 => 24,  80 => 22,  77 => 21,  74 => 20,  71 => 19,  68 => 18,  65 => 17,  62 => 16,  59 => 15,  56 => 14,  53 => 12,  50 => 11,  47 => 10,  44 => 8,  27 => 7,  22 => 3,  21 => 2,  19 => 1,);
    }
}
