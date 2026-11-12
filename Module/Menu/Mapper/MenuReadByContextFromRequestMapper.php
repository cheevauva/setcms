<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\ACL\VO\ACLRoleVO;

class MenuReadByContextFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) string $path;
    public protected(set) string $queryParams;
    public protected(set) ACLRoleVO $role;

    #[\Override]
    protected function run(): void
    {
        $this->path = $this->request->getHeaderLine('Root-Context-Path');
        $this->queryParams = $this->request->getHeaderLine('Root-Context-Query');
        $this->role = $this->request->getAttribute('currentUserRole') ?: throw new \Exception('currentUserRole undefined');
    }
}
