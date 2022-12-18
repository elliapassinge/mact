<?php

namespace Mact\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', 'mact_home')]
    #[Template('base.html.twig')]
    public function __invoke(): array
    {
        return [];
    }
}
