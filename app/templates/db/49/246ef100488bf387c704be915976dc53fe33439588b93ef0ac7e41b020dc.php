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
        $context["image_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        // line 4
        $context["preview_image_url"] = ((isset($context["assetspath"]) ? $context["assetspath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), ".")));
        // line 5
        $context["image_ratio"] = (($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "height") / $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "width")) * 100);
        // line 6
        $context["date"] = $this->getAttribute($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"), "date_taken", array(), "array");
        // line 8
        echo "
";
        // line 10
        if ((call_user_func_array($this->env->getFilter('length')->getCallable(), array($this->env, (isset($context["parent_images"]) ? $context["parent_images"] : null))) > 1)) {
            // line 11
            echo "<div class=article-nav>

\t";
            // line 14
            echo "\t";
            if ((isset($context["next_image"]) ? $context["next_image"] : null)) {
                // line 15
                echo "\t\t";
                $context["url"] = (("../" . call_user_func_array($this->env->getFunction('getSibling')->getCallable(), array(call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "file_name")))))) . "/");
                // line 16
                echo "\t\t<a href='";
                echo (isset($context["url"]) ? $context["url"] : null);
                echo "' class='next'><span>";
                echo (($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "title", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "title"), $this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "name")))) : ($this->getAttribute((isset($context["next_image"]) ? $context["next_image"] : null), "name")));
                echo "</span></a>
\t";
            }
            // line 18
            echo "
\t";
            // line 20
            echo "\t";
            if ((isset($context["prev_image"]) ? $context["prev_image"] : null)) {
                // line 21
                echo "\t\t";
                $context["url"] = (("../" . call_user_func_array($this->env->getFunction('getSibling')->getCallable(), array(call_user_func_array($this->env->getFilter('removeExtension')->getCallable(), array($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "file_name")))))) . "/");
                // line 22
                echo "\t\t<a href='";
                echo (isset($context["url"]) ? $context["url"] : null);
                echo "' class='previous'><span>";
                echo (($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "title", array(), "any", true, true)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "title"), $this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "name")))) : ($this->getAttribute((isset($context["prev_image"]) ? $context["prev_image"] : null), "name")));
                echo "</span></a>
\t";
            }
            // line 24
            echo "

\t";
            // line 36
            echo "</div>
";
        }
        // line 38
        echo "
";
        // line 40
        $context["fotomoto"] = "";
        // line 41
        $context["fotomoto_collection"] = "";
        // line 42
        if ((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "enabled") && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "store_id")) && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "enabled_page"))) {
            // line 43
            echo "\t";
            if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "buy_button")) {
                // line 44
                echo "\t\t";
                $context["fotomoto"] = " file-fotomoto file-fotomoto-buybutton";
                // line 45
                echo "\t";
            } else {
                // line 46
                echo "\t\t";
                $context["fotomoto"] = " file-fotomoto";
                // line 47
                echo "\t";
            }
            // line 48
            echo "\t";
            if (call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "collection")))) {
                // line 49
                echo "\t\t";
                $context["fotomoto_collection"] = ((" data-fotomoto-collection=\"" . call_user_func_array($this->env->getFilter('trim')->getCallable(), array($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "plugins"), "fotomoto"), "collection")))) . "\"");
                // line 50
                echo "\t";
            }
        }
        // line 52
        echo "
";
        // line 54
        echo "<div class='module row file gallery";
        echo (isset($context["fotomoto"]) ? $context["fotomoto"] : null);
        echo "'";
        echo (isset($context["fotomoto_collection"]) ? $context["fotomoto_collection"] : null);
        echo ">
  <div data-options='caption:' class='images clearfix context small-12 medium-10 large-8 small-centered columns narrower text-center frame";
        // line 55
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled") == true)) {
            echo " x3-hover-icon-primary";
        }
        echo "'>

  ";
        // line 58
        echo "
  <h1 class='title'>";
        // line 59
        echo (isset($context["page_title"]) ? $context["page_title"] : null);
        echo "</h1>
  ";
        // line 60
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["image_description"]) ? $context["image_description"] : null))))) {
            echo "<h2 class='subheader'>";
            echo (isset($context["image_description"]) ? $context["image_description"] : null);
            echo "</h2>";
        }
        // line 61
        echo "  ";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["date"]) ? $context["date"] : null))))) {
            echo "<h6 class=date><time itemprop=\"dateCreated\" datetime='";
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "c"));
            echo "'>";
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
            echo "</time></h6>";
        }
        // line 62
        echo "
  ";
        // line 64
        echo "\t<a href=";
        echo call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "permalink"), (isset($context["rootpath"]) ? $context["rootpath"] : null)));
        echo " class='back'></a>

\t";
        // line 67
        echo "\t";
        $context["exif"] = "";
        // line 68
        echo "\t";
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["parent"]) ? $context["parent"] : null), "popup"), "caption"), "exif") && $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"))) {
            // line 69
            echo "\t\t";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"));
            foreach ($context['_seq'] as $context["key"] => $context["val"]) {
                if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["val"]) ? $context["val"] : null))))) {
                    // line 70
                    echo "\t    ";
                    $context["exif"] = (((((isset($context["exif"]) ? $context["exif"] : null) . (isset($context["key"]) ? $context["key"] : null)) . ":") . (isset($context["val"]) ? $context["val"] : null)) . ";");
                    // line 71
                    echo "\t\t";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 72
            echo "\t\t";
            if ((isset($context["exif"]) ? $context["exif"] : null)) {
                // line 73
                echo "\t\t\t";
                $context["exif"] = (("data-exif=\"" . (isset($context["exif"]) ? $context["exif"] : null)) . "\"");
                // line 74
                echo "\t\t";
            }
            // line 75
            echo "\t";
        }
        // line 76
        echo "
\t";
        // line 78
        echo "\t<div class=gallery>
\t\t<a class='item img-link item-link";
        // line 79
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "popup"), "enabled") == true)) {
            echo " x3-popup";
        }
        echo "' ";
        echo (isset($context["exif"]) ? $context["exif"] : null);
        echo " id='";
        echo call_user_func_array($this->env->getFilter('lower')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "slug"), array("_" => "-")))));
        echo "' data-options='w:";
        echo $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "width");
        echo ";h:";
        echo $this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "height");
        echo "' href='";
        echo (isset($context["image_page"]) ? $context["image_page"] : null);
        echo "' data-image='";
        echo (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null);
        echo "' data-title='";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["page_title"]) ? $context["page_title"] : null), "html"));
        echo "' data-description='";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["image_description"]) ? $context["image_description"] : null), "html"));
        echo "' data-date='";
        echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, (isset($context["date"]) ? $context["date"] : null), "d F Y"));
        echo "'>

\t\t\t<figure>
\t\t\t\t<div class='image-container' style='padding-bottom:";
        // line 82
        echo (isset($context["image_ratio"]) ? $context["image_ratio"] : null);
        echo "%;'>
\t\t\t\t\t<img data-src='";
        // line 83
        echo (isset($context["preview_image_url"]) ? $context["preview_image_url"] : null);
        echo "' alt='";
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array((isset($context["page_title"]) ? $context["page_title"] : null))), "html"));
        echo "'>
\t\t\t\t</div>
\t\t\t</figure>
\t\t</a>
\t</div>

\t";
        // line 90
        echo "\t";
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"))))) {
            // line 91
            echo "\t<div class=meta>
\t\t";
            // line 92
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["myimage"]) ? $context["myimage"] : null), "exif"));
            foreach ($context['_seq'] as $context["key"] => $context["val"]) {
                if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array((isset($context["val"]) ? $context["val"] : null))))) {
                    // line 93
                    echo "\t\t\t<div class='row ";
                    echo (isset($context["key"]) ? $context["key"] : null);
                    echo "'>
\t    \t<div class='small-6 columns meta-key'><span>";
                    // line 94
                    echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('title')->getCallable(), array($this->env, (isset($context["key"]) ? $context["key"] : null))), array("_" => " ")));
                    echo "</span></div>
\t    \t<div class='small-6 columns meta-value styled'>";
                    // line 95
                    echo (isset($context["val"]) ? $context["val"] : null);
                    echo "</div>
\t    </div>
\t\t";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 98
            echo "\t</div>
\t";
        }
        // line 100
        echo "
\t";
        // line 102
        echo "\t";
        if (($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "accounts"), "disqus_shortname") && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "plugins"), "disqus"), "image"))) {
            // line 103
            echo "\t\t<hr>
\t\t<div id=\"comments\">
\t\t\t<div>
\t\t\t\t<h2>Comments</h2>
\t\t\t\t<div id=\"disqus_thread\"></div>
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 111
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
        return array (  291 => 111,  281 => 103,  278 => 102,  275 => 100,  271 => 98,  261 => 95,  257 => 94,  252 => 93,  247 => 92,  244 => 91,  241 => 90,  230 => 83,  226 => 82,  200 => 79,  197 => 78,  194 => 76,  191 => 75,  188 => 74,  185 => 73,  182 => 72,  175 => 71,  172 => 70,  166 => 69,  163 => 68,  160 => 67,  154 => 64,  151 => 62,  142 => 61,  136 => 60,  132 => 59,  129 => 58,  122 => 55,  115 => 54,  112 => 52,  108 => 50,  105 => 49,  102 => 48,  99 => 47,  96 => 46,  93 => 45,  90 => 44,  87 => 43,  85 => 42,  83 => 41,  81 => 40,  78 => 38,  74 => 36,  70 => 24,  62 => 22,  59 => 21,  56 => 20,  53 => 18,  45 => 16,  42 => 15,  39 => 14,  35 => 11,  33 => 10,  30 => 8,  28 => 6,  26 => 5,  24 => 4,  22 => 3,  19 => 1,);
    }
}
