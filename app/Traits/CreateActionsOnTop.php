<?php 

namespace App\Traits;

trait CreateActionsOnTop
{
    protected function getHeaderActions(): array
    { 
        return [
            $this->getCreateFormAction()->formId('form'),

            $this->getCreateAnotherFormAction(),

            $this->getCancelFormAction(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
