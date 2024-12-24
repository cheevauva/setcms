<?php

declare(strict_types=1);

namespace SetCMS\Module\Mirror\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Mirror\DAO\MirrorRetrieveManyControllersDAO;
use SetCMS\Module\Mirror\DAO\MirrorRetrieveManyMethodsByControllerDAO;

class MirrorPublicController
{

    use \SetCMS\Traits\ControllerTrait;

    #[RequestMethod('GET')]
    public function export()
    {
        echo '<pre>';

        $retrieveControllers = MirrorRetrieveManyControllersDAO::make($this->factory());
        $retrieveControllers->serve();

        foreach ($retrieveControllers->controllers as $contoller) {
            $retrieveMethods = MirrorRetrieveManyMethodsByControllerDAO::make($this->factory());
            $retrieveMethods->controller = $contoller;
            $retrieveMethods->serve();

            print_r([
                $contoller,
                $retrieveMethods->methods,
            ]);
        }

        die;
    }
}
