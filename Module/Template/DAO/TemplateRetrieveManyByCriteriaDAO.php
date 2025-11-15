<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use Module\Template\Entity\TemplateEntity;
use Module\Template\Exception\TemplateNotFoundException;

class TemplateRetrieveManyByCriteriaDAO extends \SetCMS\DAO\EntityRetrieveManyByCriteriaDAO
{

    use TemplateCommonDAO;

    /**
     * @var array<TemplateEntity>
     */
    public array $templates;
    public ?TemplateEntity $template;
    public string $slug;

    #[\Override]
    public function serve(): void
    {
        if (isset($this->slug)) {
            $this->criteria['slug'] = $this->slug;
        }
        
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
