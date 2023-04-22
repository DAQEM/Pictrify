<?php

namespace Pictrify\Gateway;

use MongoDB\Collection;
use Pictrify\ISectionGateway;

class SectionGateway implements ISectionGateway
{
    private Collection $sectionCollection;

    public function __construct()
    {
        $this->sectionCollection = (new DatabaseHelper())->getSectionCollection();
    }

    public function getAllSections(): array
    {
        return $this->sectionCollection->find()->toArray();
    }
}