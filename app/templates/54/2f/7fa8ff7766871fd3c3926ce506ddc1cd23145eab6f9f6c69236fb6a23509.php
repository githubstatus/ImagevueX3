<?php

/* partials/site.json */
class __TwigTemplate_542f7fa8ff7766871fd3c3926ce506ddc1cd23145eab6f9f6c69236fb6a23509 extends Twig_Template
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
        $context["rootpath"] = (call_user_func_array($this->env->getFilter('replace')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "base_url"), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name") => ""))) . "/");
        // line 3
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
            // line 4
            ob_start();
            // line 5
            if ((call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "protected"))) && call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "link"), "url"))))) {
                $this->env->loadTemplate("page.json")->display(array_merge($context, array("page" => (isset($context["child"]) ? $context["child"] : null))));
                echo ",";
            }
            // line 6
            if (($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children_count") > 0)) {
                $this->env->loadTemplate("partials/site.json")->display(array_merge($context, array("node" => $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children"))));
            }
            $context["page_data"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 8
            if ((isset($context["page_data"]) ? $context["page_data"] : null)) {
                echo "\"";
                echo ((isset($context["rootpath"]) ? $context["rootpath"] : null) . $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "permalink"));
                echo "\" : ";
                echo (isset($context["page_data"]) ? $context["page_data"] : null);
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
        return "partials/site.json";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 8,  45 => 6,  40 => 5,  38 => 4,  21 => 3,  19 => 2,);
    }
}
