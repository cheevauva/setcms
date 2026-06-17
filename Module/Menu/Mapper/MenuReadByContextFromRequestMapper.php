<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use SetCMS\View\View;
use SetCMS\Responder;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;
use Psr\Http\Message\ServerRequestInterface;

class MenuReadByContextFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) View|Responder $view;
    public protected(set) ACLRoleVO $role;

    #[\Override]
    public function serve(): void
    {
        $this->view = $this->request->getAttribute('view') ?: throw new \Exception('view undefined');
        $this->role = $this->parentRequest()->getAttribute('currentUserRole') ?: throw new \Exception('currentUserRole undefined');
    }

    protected function parentRequest(): ServerRequestInterface
    {
        return $this->request->getAttribute('parentRequest');
    }
}
