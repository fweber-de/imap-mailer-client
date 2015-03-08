<?php

namespace Mailer\AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ellipse', array($this, 'ellipseFilter')),
        );
    }

    public function ellipseFilter($str, $length = 30)
    {
        if (strlen($str) <= $length) {
            return $str;
        }

        return substr($str, 0, $length - 3).'...';
    }

    public function getName()
    {
        return 'app_extension';
    }
}
