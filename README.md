# Livewire locked properties for Livewire v. 2

The package allows you to designate component properties as locked.

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

It is also necessary to declare a updated method in the component for locked property. 
Example: for property 'name' the method will look like updatedName.
In this method you need to call the method updateLockedProperty 
and pass the property name into it.

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
    
    public function updatedName($value)
    {
        $this->updateLockedProperty('name');
    }
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
    
    public function updatedName($value)
    {
        $this->updateLockedProperty('name');
    }
...
```

If a component has both a method and a property, the method will take precedence.

The package uses a system of hooks via traits

## Important


### The value of protected properties is stored in the session. When recording to a session, a key is generated based on the component name.

## For this reason, if you place two identical components on the page, the value of the locked property will be the value of the last component rendered

## License

The MIT License (MIT). Please see [License.md](LICENSE.md) for more information.
