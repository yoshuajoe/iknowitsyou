<?php

namespace Ikiy\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class BaseController
 *
 * @package Ikiy\AppBundle\Controller
 */
abstract class BaseController extends Controller {
    /**
     * {@inheritDoc}
     */
    public final function render($view, array $parameters = array(), Response $response = null) {
        $realView = $this->getView($view);

        return parent::render($realView, array_merge($parameters, $this->getParameters()), $response);
    }

    /**
     * {@inheritDoc}
     */
    public function renderView($view, array $parameters = array()) {
        $realView = $this->getView($view);

        return parent::renderView($realView, array_merge($parameters, $this->getParameters()));
    }

    /**
     * Get twig friendly view name
     *
     * @param string $view
     * @return string The twig friendly view name
     */
    private function getView($view) {
        if(!strpos($view, '/') && !strpos($view, '\\')) {
            $realView = $this->getBundleName().BUNDLE_SEPARATOR.BUNDLE_SEPARATOR.$view;
        }
        else {
            $first = null;
            if(!(count($exploded = explode("/", $view)) >= 3)) {
                $realView = str_replace(array('/', '\\'), BUNDLE_SEPARATOR, $view);
            } else {
                $first = ucfirst(array_shift($exploded));

                $realView = implode(BUNDLE_SEPARATOR, $exploded);
            }

            $realView = explode(BUNDLE_SEPARATOR, $realView);

            array_walk($realView, function(&$piece){
                $piece = strpos($piece, '.') ? $piece : ucfirst($piece);
            });

            $last = array_pop($realView);
            $realView = implode('/', $realView);

            $realView = [$realView, $last];

            $realView = implode(BUNDLE_SEPARATOR, $realView);

            if (strpos($view, $this->getBundleName()) === false) {
                $bundle = $this->getBundleName().BUNDLE_SEPARATOR;

                $realView  = $first !== null ? $bundle.$first.'/'.$realView : $bundle.$realView;
            }
        }

        return $realView;
    }

    /**
     * Redirect response with flash messages
     *
     * @param string  $url
     * @param Session $session
     * @param array   $flashes
     * @return RedirectResponse
     */
    public function redirectWithFlash($url, Session $session, $flashes) {
        $session->getFlashBag()->clear();

        foreach($flashes as $type => $message) {
            $session->getFlashBag()->add($type, $message);
        }

        return parent::redirect($url, 302);
    }

    protected function getParameters() {
        return [];
    }

    protected function getBundleName() {
        return 'IkiyAppBundle';
    }
}