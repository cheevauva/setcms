<?php

namespace SetCMS;

class Router extends \AltoRouter
{

    public function match($requestUrl = null, $requestMethod = null)
    {
        $result = parent::match($requestUrl, $requestMethod);
        
        if (is_array($result)) {
            $result['target']['method'] = $requestMethod;
        }
        
        return $result;
    }

}
