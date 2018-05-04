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
        // line 1
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(((array_key_exists("node", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["node"]) ? $context["node"] : null), $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root")))) : ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root"))));
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
            // line 2
            echo "<url>
    <loc>";
            // line 3
            echo call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
            echo "</loc>
    <lastmod>";
            // line 4
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "updated"), "c"));
            echo "</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
    ";
            // line 7
            ob_start();
            $this->env->loadTemplate("partials/preview-image.html")->display(array_merge($context, array("page" => (isset($context["child"]) ? $context["child"] : null))));
            $context["preview_image"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 8
            echo "    ";
            if ((isset($context["preview_image"]) ? $context["preview_image"] : null)) {
                // line 9
                echo "  \t<image:image>
       <image:loc>";
                // line 10
                echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
                echo call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["preview_image"]) ? $context["preview_image"] : null), "."));
                echo "</image:loc>
    </image:image>
  \t";
            }
            // line 13
            echo "</url>
";
            // line 14
            if (($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children_count") > 0)) {
                // line 15
                $this->env->loadTemplate("partials/sitemap/sitemap-url.xml")->display(array_merge($context, array("node" => $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children"))));
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
        return array (  71 => 15,  69 => 14,  66 => 13,  59 => 10,  56 => 9,  53 => 8,  49 => 7,  43 => 4,  39 => 3,  36 => 2,  48 => 17,  46 => 16,  41 => 14,  37 => 12,  35 => 11,  33 => 10,  31 => 9,  29 => 8,  26 => 6,  24 => 5,  21 => 2,  19 => 1,);
    }
}
