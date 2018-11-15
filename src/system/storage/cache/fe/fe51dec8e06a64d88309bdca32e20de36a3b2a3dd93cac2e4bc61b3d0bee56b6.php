<?php

/* default/template/common/home.twig */
class __TwigTemplate_21ce9826ba721a8364494831b104d2c39ecc83419f23f3920869eeaaa6814ae6 extends Twig_Template
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
        echo "<html>
<head>
</head>
<body>
<div id=\"common-home\" class=\"container\">
  <div class=\"row\">
    ";
        // line 7
        $context["class"] = "col-sm-12";
        // line 8
        echo "    <div id=\"content\" class=\"";
        echo ($context["class"] ?? null);
        echo "\"></div>
      <b>Hello world!</b>
    </div>
</div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "default/template/common/home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 8,  27 => 7,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default/template/common/home.twig", "D:\\MY_PROGRAM\\Develop\\OpenBlog\\upload\\catalog\\view\\theme\\default\\template\\common\\home.twig");
    }
}
