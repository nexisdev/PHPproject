<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $search)
    {
        foreach ($this->getSearchableAttributes() as $field) {
            $query->orWhere($field, "LIKE", "%" . $search . "%");
        }

        return $query;
    }

    public function getSearchableAttributes(): array
    {
        return is_array($this->searchableFields)
            ? $this->searchableFields
            : [];
    }
}
