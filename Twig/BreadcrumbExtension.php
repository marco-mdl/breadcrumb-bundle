<?php

namespace Thormeier\BreadcrumbBundle\Twig;

use Thormeier\BreadcrumbBundle\Provider\BreadcrumbProviderInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension for breadcrumbs: Render a given template
 */
class BreadcrumbExtension extends AbstractExtension
{
    /**
     * @var BreadcrumbProviderInterface
     */
    private $breadcrumbProvider;

    /**
     * @var string
     */
    private $template;

    /**
     * @param BreadcrumbProviderInterface $breadcrumbProvider
     * @param                             $template
     */
    public function __construct(BreadcrumbProviderInterface $breadcrumbProvider, $template)
    {
        $this->breadcrumbProvider = $breadcrumbProvider;
        $this->template = $template;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'breadcrumbs',
                [
                    $this,
                    'renderBreadcrumbs',
                ],
                [
                    'needs_environment' => TRUE,
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    /**
     * @param Environment $twigEnvironment
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function renderBreadcrumbs(Environment $twigEnvironment)
    {
        return $twigEnvironment->render($this->template, [
            'breadcrumbs' => $this->breadcrumbProvider->getBreadcrumbs()->getAll(),
        ]);
    }

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getName()
    {
        return 'thormeier.breadcrumb_bundle.twig_extension';
    }
}
