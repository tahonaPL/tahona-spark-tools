<?php
/**
 * Created by PhpStorm.
 * User: primosz67
 * Date: 06.03.17
 * Time: 07:29
 */

namespace spark\security\core\filter;


use spark\core\annotation\Inject;
use spark\filter\FilterChain;
use spark\filter\HttpFilter;
use spark\http\Request;
use spark\http\RequestProvider;
use spark\Routing;
use spark\security\core\SecurityManager;
use spark\security\core\service\AuthenticationService;
use spark\security\exception\AccessDeniedException;

class SecurityFilter implements HttpFilter {

    /**
     * @Inject()
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @Inject()
     * @var SecurityManager
     */
    private $securityManager;

    function doFilter(Request $request, FilterChain $filterChain) {

        $urlRoles = $this->securityManager->getRoles();
        $hasUserAccess = $this->authenticationService->hasUserAccess($urlRoles);

        if (!$hasUserAccess) {
            throw new AccessDeniedException();
        }

        $filterChain->doFilter($request);
    }
}