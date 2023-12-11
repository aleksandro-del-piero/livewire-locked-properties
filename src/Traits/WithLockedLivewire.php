<?php


namespace AleksandroDelPiero\LivewireLockedProperties\Traits;


trait WithLockedLivewire
{
    public function updatingWithLockedLivewire($propertyName, $value): void
    {
        $this->updateLockedProperty($propertyName);
    }

    public function updatedWithLockedLivewire($propertyName, $value): void
    {
        $this->updateLockedProperty($propertyName);
    }

    public function mountWithLockedLivewire($lockedKey): void
    {
        if (count($this->getLocked()) > 0) {
            session()->put($this->generateLockedSessionComponentName(), [
                'lockedPropertiesWithValues' => $this->getLockedPropertiesWithValues()
            ]);
        } else {
            session()->forget($this->generateLockedSessionComponentName());
        }
    }

    protected function isLocked(string $propertyName): bool
    {
        return in_array($propertyName, $this->getLocked());
    }

    protected function getLocked(): array
    {
        if (method_exists($this, 'locked')) return $this->locked();
        if (property_exists($this, 'locked')) return $this->locked;

        return [];
    }

    protected function getLockedPropertiesWithValues(): array
    {
        $lockedProperties = $this->getLocked();

        $result = [];

        foreach ($lockedProperties as $lockedProperty) {
            $result[$lockedProperty] = $this->{$lockedProperty};
        }

        return $result;
    }

    protected function generateLockedSessionComponentName(): string
    {
        return 'locked' . $this::class;
    }

    protected function updateLockedProperty($propertyName): void
    {
        if ($this->isLocked($propertyName)) {
            $lockedFromSession = session()->get($this->generateLockedSessionComponentName());

            if (is_null($lockedFromSession)) {
                return;
            }

            $lockedPropertiesWithValues = $lockedFromSession['lockedPropertiesWithValues'];

            foreach ($lockedPropertiesWithValues as $lockedPropertyName => $lockedPropertyValue) {
                if ($propertyName == $lockedPropertyName) {
                    $this->{$lockedPropertyName} = $lockedPropertyValue;
                }
            }
        }
    }
}
