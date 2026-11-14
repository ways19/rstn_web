<?php

namespace App\Modules\Content\Contracts;

use App\Models\PpidDocument;
use App\Modules\Common\Contracts\BaseRepositoryInterface;

interface PpidDocumentRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveDocuments();

    public function getActiveDocumentsByMenu(string $menu);
}