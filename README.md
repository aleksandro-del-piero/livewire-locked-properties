# Livewire locked properties for Livewire v. 2

The package allows you to designate component properties as locked.

### Tested package on Livewire v2.12.6

## Installation

You can install the package via composer:

``` bash
composer require aleksandro_del_piero/livewire-locked-properties
```

## Documentation

You need to add a trait to the component
AleksandroDelPiero\LivewireLockedProperties\Traits\WithLockedLivewire;

To designate a property as protected, 
you must add it to a protected property $locked or declare a method locked().

```phg
namespace App\Http\Livewire;

use Livewire\Component;
use AleksandroDelPiero\LivewireLockedProperties\Traits\WithLockedLivewire;

class TestLivewire extends Component
{
    use WithLockedLivewire;

    public $name;

    protected $locked = [
        'name'
    ];
...
```

or a protected method 'locked'

```php 
namespace App\Http\Livewire;

use Livewire\Component;
use AleksandroDelPiero\LivewireLockedProperties\Traits\WithLockedLivewire;

class TestLivewire extends Component
{
    use WithLockedLivewire;

    public $name;

    protected function locked(): array
    {
        return ['name'];
    }
...
```

If a component has both a method and a property, the method will take precedence.

## License

The MIT License (MIT). Please see [License.md](LICENSE.md) for more information.
