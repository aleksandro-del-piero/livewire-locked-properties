<?php

namespace AleksandroDelPiero\LivewireLockedProperties;

use AleksandroDelPiero\LivewireLockedProperties\Http\Middlewares\PerformDataBindingUpdates;
use Illuminate\Support\ServiceProvider;
use Livewire\LifecycleManager;
use Livewire\HydrationMiddleware\{
    RenderView,
    PerformActionCalls,
    CallHydrationHooks,
    PerformEventEmissions,
    HydratePublicProperties,
    CallPropertyHydrationHooks,
    SecureHydrationWithChecksum,
    HashDataPropertiesForDirtyDetection,
    NormalizeServerMemoSansDataForJavaScript,
    NormalizeComponentPropertiesForJavaScript,
};


class LivewireLockedPropertiesServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerHydrationMiddleware();
    }

    protected function registerHydrationMiddleware()
    {
        LifecycleManager::registerHydrationMiddleware([

            /* This is the core middleware stack of Livewire. It's important */
            /* to understand that the request goes through each class by the */
            /* order it is listed in this array, and is reversed on response */
            /*                                                               */
            /* ↓    Incoming Request                  Outgoing Response    ↑ */
            /* ↓                                                           ↑ */
            /* ↓    Secure Stuff                                           ↑ */
            /* ↓ */ SecureHydrationWithChecksum::class, /* --------------- ↑ */
            /* ↓ */ NormalizeServerMemoSansDataForJavaScript::class, /* -- ↑ */
            /* ↓ */ HashDataPropertiesForDirtyDetection::class, /* ------- ↑ */
            /* ↓                                                           ↑ */
            /* ↓    Hydrate Stuff                                          ↑ */
            /* ↓ */ HydratePublicProperties::class, /* ------------------- ↑ */
            /* ↓ */ CallPropertyHydrationHooks::class, /* ---------------- ↑ */
            /* ↓ */ CallHydrationHooks::class, /* ------------------------ ↑ */
            /* ↓                                                           ↑ */
            /* ↓    Update Stuff                                           ↑ */
            /* ↓ */ PerformDataBindingUpdates::class, /* ----------------- ↑ */
            /* ↓ */ PerformActionCalls::class, /* ------------------------ ↑ */
            /* ↓ */ PerformEventEmissions::class, /* --------------------- ↑ */
            /* ↓                                                           ↑ */
            /* ↓    Output Stuff                                           ↑ */
            /* ↓ */ RenderView::class, /* -------------------------------- ↑ */
            /* ↓ */ NormalizeComponentPropertiesForJavaScript::class, /* - ↑ */

        ]);
    }
}
