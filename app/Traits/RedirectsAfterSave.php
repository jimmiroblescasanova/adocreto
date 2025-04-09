<?php

namespace App\Traits;

trait RedirectsAfterSave
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
