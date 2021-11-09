<?php

namespace SetCMS\Module\Blocks;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Blocks\Block;
use SetCMS\Module\Blocks\BlockException;

class BlockDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof Block);
        
        $record = [
            'side' => $entity->side,
            'block' => $entity->block,
            'name' => $entity->name,
        ];
        
        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getException(): \Exception
    {
        return new BlockException;
    }

    protected function getTableName(): string
    {
        return 'blocks';
    }

    protected function record2entity(array $record): Block
    {
        $entity = new Block;
        $entity->side = $record['side'];
        $entity->name = $record['name'];
        $entity->block = $record['block'];

        return $this->ordinaryRecord2EntityBind($record, $entity);
    }

}
