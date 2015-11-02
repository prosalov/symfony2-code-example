<?php

namespace AdminBundle\Menu\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Voter based on the baseUrl
 */
class UriRequestVoter implements VoterInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Request setter
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Match menu item
     *
     * @param ItemInterface $item Menu item
     *
     * @return bool|null
     */
    public function matchItem(ItemInterface $item)
    {
        if (null === $this->request) {
            return null;
        }

        $controller = $this->request->attributes->get('_controller');
        preg_match('#Controller\\\([a-zA-Z]*)Controller#', $controller, $matches);

        $controllerName = null;
        if (! empty($matches[1])) {
            $controllerName = mb_strtolower($matches[1], mb_detect_encoding($matches[1]));
        }

        if (empty($controllerName)) {
            return null;
        }

        $route = $item->getUri();
        $routeRequest = $this->request->getBaseUrl() . '/' .  $controllerName . '/';

        if ($route == $routeRequest) {
            return true;
        }

        return null;
    }
}