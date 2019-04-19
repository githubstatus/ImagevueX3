<?php

/* partials/sitemap/sitemap-url.xml */
class __TwigTemplate_556aeb52252186becb72c78b69c5bcdfaaa3dce7df7fbb7f70c8e8c8445cae5f extends Twig_Template
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
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(((array_key_exists("node", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["node"]) ? $context["node"] : null), $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root")))) : ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root"))));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            if (call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "url")))) {
                // line 3
                echo "<url>
    <loc>";
                // line 4
                echo call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
                echo "</loc>
    <lastmod>";
                // line 5
                echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "updated"), "c"));
                echo "</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
    ";
                // line 8
                ob_start();
                $this->env->loadTemplate("partials/preview-image.html")->display(array_merge($context, array("page" => (isset($context["child"]) ? $context["child"] : null))));
                $context["preview_image"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 9
                echo "    ";
                if ((isset($context["preview_image"]) ? $context["preview_image"] : null)) {
                    // line 10
                    echo "  \t<image:image>
       <image:loc>";
                    // line 11
                    echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
                    echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), "."));
                    echo "</image:loc>
    </image:image>
  \t";
                }
                // line 14
                echo "</url>
";
                // line 15
                if (($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children_count") > 0)) {
                    // line 16
                    $this->env->loadTemplate("partials/sitemap/sitemap-url.xml")->display(array_merge($context, array("node" => $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children"))));
                }
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "partials/sitemap/sitemap-url.xml";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 16,  63 => 15,  60 => 14,  53 => 11,  50 => 10,  47 => 9,  43 => 8,  30 => 3,  48 => 16,  46 => 15,  41 => 13,  37 => 5,  35 => 10,  33 => 4,  31 => 8,  29 => 7,  26 => 5,  24 => 4,  21 => 2,  19 => 2,);
    }
}
