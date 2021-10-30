<?php

namespace SetCMS\Module\Captcha;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Captcha\Captcha;
use SetCMS\Module\Captcha\CaptchaException;

class CaptchaDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof Captcha);

        $record = [
            'text' => $entity->text(),
            'date_expiried' => $entity->dateExpiried->format('Y-m-d H:i:s'),
            'solve_attempts' => $entity->solveAttempts,
            'is_used' => (int) $entity->isUsed,
            'is_solved' => (int) $entity->isSolved,
        ];

        return $this->ordinaryEntity2RecordBind($entity, $record);
    }
    
    public function get(string $id): Captcha
    {
        return parent::get($id);
    }

    protected function getException(): CaptchaException
    {
        return new CaptchaException;
    }

    protected function getTableName(): string
    {
        return 'captcha';
    }

    protected function record2entity(array $record): Captcha
    {
        $entity = new Captcha;
        $entity->text($record['text']);
        $entity->dateExpiried = new \DateTime($record['date_expiried']);
        $entity->isSolved = !empty($record['is_solved']);
        $entity->isUsed = !empty($record['is_used']);
        $entity->solveAttempts = (int) $record['solve_attempts'];

        return $this->ordinaryRecord2EntityBind($record, $entity);
    }

}
