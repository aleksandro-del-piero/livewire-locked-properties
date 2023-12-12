<?php

namespace AleksandroDelPiero\LivewireLockedProperties\Http\Middlewares;

use Illuminate\Validation\ValidationException;
use Livewire\HydrationMiddleware\HydrationMiddleware;
use Livewire\Livewire;


class PerformDataBindingUpdates implements HydrationMiddleware
{
    public static function hydrate($unHydratedInstance, $request)
    {
        try {
            $componentLockedProperties = $unHydratedInstance->getLocked();

            foreach ($request->updates as $update) {
                if ($update['type'] !== 'syncInput') continue;

                $data = $update['payload'];

                if (! array_key_exists('value', $data)) continue;

                $data = self::updatePropertyValueWhenExistsInLockedProperties($data, $componentLockedProperties, $request->memo['data']);

                $unHydratedInstance->syncInput($data['name'], $data['value']);
            }
        } catch (ValidationException $e) {
            Livewire::dispatch('failed-validation', $e->validator, $unHydratedInstance);

            $unHydratedInstance->setErrorBag($e->validator->errors());
        }
    }

    public static function dehydrate($instance, $response)
    {
        //
    }

    protected static function updatePropertyValueWhenExistsInLockedProperties($data, $lockedProperties, $memo)
    {
        $namePropertyExistsInLockedProperties = array_search($data['name'], $lockedProperties);

        if($namePropertyExistsInLockedProperties !== false) {
            $data['value'] = $memo[$data['name']];
        }

        return $data;
    }
}
