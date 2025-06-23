<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\DAO;

use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\Exception\TemplateNotFoundException;

class TemplateRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use TemplateCommonDAO;

    /**
     * @var array<TemplateEntity>
     */
    public array $templates;
    public ?TemplateEntity $template;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->templates = TemplateEntity::manyAs($this->entities);
        $this->template = $this->first ? TemplateEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new TemplateNotFoundException();
    }
}
