<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Controller;

use SetCMS\Module\Template\View\TemplatePrivateEditView;

class TemplatePrivateEditController extends TemplatePrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            TemplatePrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplatePrivateEditView) {
            $object->template = $this->template;
        }
    }
}
