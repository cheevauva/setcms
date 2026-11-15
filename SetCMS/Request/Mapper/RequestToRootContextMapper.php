<?php

declare(strict_types=1);

namespace SetCMS\Request\Mapper;

use SetCMS\DTO\RootContextDTO;
use SetCMS\Request\Exception\RequestInvalidException;

class RequestToRootContextMapper extends RequestMapper
{

    public protected(set) RootContextDTO $rootContext;

    #[\Override]
    protected function run(): void
    {
        $rootContext = $this->rootContext = new RootContextDTO;

        if (!$this->request->hasHeader('Root-Context-Path')) {
            throw new RequestInvalidException('Не задан Root-Context-Path');
        }

        if (!$this->request->hasHeader('Root-Context-Query')) {
            throw new RequestInvalidException('Не задан Root-Context-Query');
        }

        $queryParams = [];

        parse_str($this->request->getHeaderLine('Root-Context-Query'), $queryParams);

        $rootContext->path = $this->request->getHeaderLine('Root-Context-Path');
        $rootContext->queryParams = $queryParams;
    }
}
