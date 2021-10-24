<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SetCMS\Module\Pages;

/**
 * Description of PageResource
 *
 * @author japanxt
 */
class PageResource
{

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->ordinary->save($request, $model);
    }

}
