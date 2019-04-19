<?php

/* feed.atom */
class __TwigTemplate_ebeae85c4b234160390182eee1672dee46cd2cceae5442c3bf444ff59a1c880e extends Twig_Template
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
        ob_start();
        // line 2
        echo "
";
        // line 5
        $context["baseurl"] = $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "base_url");
        // line 6
        echo "
";
        // line 8
        $context["absolutepath"] = call_user_func_array($this->env->getFilter('addprotocol')->getCallable(), array((isset($context["baseurl"]) ? $context["baseurl"] : null)));
        // line 9
        $context["absolutepath_page"] = call_user_func_array($this->env->getFilter('setpath')->getCallable(), array($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "permalink"), (isset($context["absolutepath"]) ? $context["absolutepath"] : null)));
        // line 10
        echo "
";
        // line 12
        $context["index"] = call_user_func_array($this->env->getFunction('get')->getCallable(), array("index"));
        // line 14
        $context["favicon"] = call_user_func_array($this->env->getFunction('firstImage')->getCallable(), array("./content/custom/favicon"));
        // line 16
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "style"), "logo"), "use_image")) {
            // line 17
            echo "\t";
            $context["logo"] = call_user_func_array($this->env->getFunction('firstImage')->getCallable(), array("./content/custom/logo"));
        }
        // line 19
        $context["logo"] = ((array_key_exists("logo", $context)) ? (call_user_func_array($this->env->getFilter('default')->getCallable(), array((isset($context["logo"]) ? $context["logo"] : null), (isset($context["favicon"]) ? $context["favicon"] : null)))) : ((isset($context["favicon"]) ? $context["favicon"] : null)));
        // line 20
        echo "
";
        // line 22
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<feed xmlns=\"http://www.w3.org/2005/Atom\" xmlns:media=\"http://search.yahoo.com/mrss/\">
<title>";
        // line 24
        echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array($this->getAttribute((isset($context["index"]) ? $context["index"] : null), "title"))), "html"));
        echo "</title>
";
        // line 25
        if ((!call_user_func_array($this->env->getTest('empty')->getCallable(), array($this->getAttribute((isset($context["index"]) ? $context["index"] : null), "description"))))) {
            echo "<subtitle>";
            echo call_user_func_array($this->env->getFilter('e')->getCallable(), array($this->env, call_user_func_array($this->env->getFilter('striptags')->getCallable(), array($this->getAttribute((isset($context["index"]) ? $context["index"] : null), "description"))), "html"));
            echo "</subtitle>";
        }
        // line 26
        echo "<link href=\"";
        echo (isset($context["absolutepath_page"]) ? $context["absolutepath_page"] : null);
        echo "\" rel=\"self\" type=\"application/atom+xml\"/>
<link href=\"";
        // line 27
        echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
        echo "/\" rel=\"alternate\" type=\"text/html\" />
<updated>";
        // line 28
        echo call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "site_updated"), "c"));
        echo "</updated>
<id>";
        // line 29
        echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
        echo "/</id>
<generator uri=\"https://www.photo.gallery\" version=\"X3\">X3</generator>
";
        // line 31
        if ((isset($context["favicon"]) ? $context["favicon"] : null)) {
            echo "<icon>";
            echo ((isset($context["absolutepath"]) ? $context["absolutepath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["favicon"]) ? $context["favicon"] : null), ".")));
            echo "</icon>";
        }
        // line 32
        if ((isset($context["logo"]) ? $context["logo"] : null)) {
            echo "<logo>";
            echo ((isset($context["absolutepath"]) ? $context["absolutepath"] : null) . call_user_func_array($this->env->getFilter('trim')->getCallable(), array((isset($context["logo"]) ? $context["logo"] : null), ".")));
            echo "</logo>";
        }
        // line 33
        echo "<rights>";
        echo (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "current_year") . " ") . $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name"));
        echo "</rights>
<author>
<name>";
        // line 35
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "domain_name");
        echo "</name>
<uri>";
        // line 36
        echo (isset($context["absolutepath"]) ? $context["absolutepath"] : null);
        echo "/</uri>
</author>
";
        // line 38
        $this->env->loadTemplate("partials/feed/feed-loop.atom")->display($context);
        // line 39
        echo "</feed>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "feed.atom";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 39,  110 => 38,  105 => 36,  101 => 35,  95 => 33,  89 => 32,  83 => 31,  78 => 29,  74 => 28,  70 => 27,  65 => 26,  59 => 25,  55 => 24,  51 => 22,  48 => 20,  46 => 19,  42 => 17,  40 => 16,  38 => 14,  36 => 12,  33 => 10,  31 => 9,  29 => 8,  26 => 6,  24 => 5,  21 => 2,  19 => 1,);
    }
}
