<?php


namespace AleksandroDelPiero\LivewireLockedProperties\Traits;


trait WithLockedLivewire
{
    public function getLocked(): array
    {
        if (method_exists($this, 'locked')) return $this->locked();
        if (property_exists($this, 'locked')) return $this->locked;

        return [];
    }
}
