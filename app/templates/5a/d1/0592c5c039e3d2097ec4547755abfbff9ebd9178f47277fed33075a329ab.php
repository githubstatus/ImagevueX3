<?php

/* partials/feed/feed-loop.atom */
class __TwigTemplate_5ad10592c5c039e3d2097ec4547755abfbff9ebd9178f47277fed33075a329ab extends Twig_Template
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
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 2
            $context["title"] = call_user_func_array($this->env->getFilter('striptags')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "title")));
            // line 3
            $context["absolutepath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
            // line 4
            echo "<entry>
<id>tag:";
            // line 5
            echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name");
            echo ",";
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "updated"), "Y-m-d"));
            echo ":";
            echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "id");
            echo "</id>
<title>";
            // line 6
            echo (isset($context["title"]) ? $context["title"] : null);
            echo "</title>
<summary>";
            // line 7
            echo call_user_func_array($this->env->getFilter('default')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description"))), "html")), (isset($context["title"]) ? $context["title"] : null)));
            echo "</summary>
<updated>";
            // line 8
            echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "updated"), "c"));
            echo "</updated>
";
            // line 9
            if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "link"), "url"))))) {
                // line 10
                if ((0 === strpos(call_user_func_array($this->env->getFilter('lower')->getCallable(), array($this->env, $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "link"), "url"))), "http"))) {
                    // line 11
                    echo "<link rel=\"alternate\" type=\"text/html\" href=\"";
                    echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, $this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "link"), "url")));
                    echo "\" />
";
                }
            } else {
                // line 14
                echo "<link rel=\"alternate\" type=\"text/html\" href=\"";
                echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)))));
                echo "\" />
";
            }
            // line 16
            ob_start();
            $this->env->loadTemplate("partials/preview-image.html")->display($context);
            $context["preview_image"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 17
            if ((isset($context["preview_image"]) ? $context["preview_image"] : null)) {
                // line 18
                echo "<media:thumbnail url=\"";
                echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
                echo call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFunction('resize_path')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image"]) ? $context["preview_image"] : null))), "200", "200", "1:1", 90)), ".")), array(" " => "%20")));
                echo "\" width=\"200\" height=\"200\" />
<media:content url=\"";
                // line 19
                echo ((isset($context["absolutepath"]) ? $context["absolutepath"] : null) . call_user_func_array($this->env->getFilter('replace')->getCallable(), array(call_user_func_array($this->env->getFilter('trim')->getCallable(), array(call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, (isset($context["preview_image"]) ? $context["preview_image"] : null))), ".")), array(" " => "%20"))));
                echo "\" />
";
            }
            // line 21
            echo "</entry>
";
            // line 22
            if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "children_count") > 0)) {
                $this->env->loadTemplate("partials/feed/feed-loop.atom")->display(array_merge($context, array("node" => $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "children"))));
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "partials/feed/feed-loop.atom";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 22,  97 => 21,  92 => 19,  86 => 18,  84 => 17,  80 => 16,  67 => 11,  63 => 9,  43 => 5,  112 => 39,  110 => 38,  105 => 36,  101 => 35,  95 => 33,  89 => 32,  83 => 31,  78 => 29,  74 => 14,  70 => 27,  65 => 10,  59 => 8,  55 => 7,  51 => 6,  48 => 20,  46 => 19,  42 => 17,  40 => 4,  38 => 3,  36 => 2,  33 => 10,  31 => 9,  29 => 8,  26 => 6,  24 => 5,  21 => 2,  19 => 1,);
    }
}
