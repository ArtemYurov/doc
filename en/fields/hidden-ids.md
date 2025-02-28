# HiddenIds

- [Basics](#basics)
- [Usage](#use)

---

<a name="basics"></a>
## Basics

Contains all [Basic Methods](/docs/{{version}}/fields/basic-methods).

The HiddenIds field is used to pass the primary key of the selected elements. For example, in a table during bulk actions, it is necessary to collect the ID values of all selected elements and send them in the form.

<a name="make"></a>
## Creation

```php
make(string $forComponent)
```

- `$formComponent` - the name of the component with the list of elements.

```php
use MoonShine\UI\Fields\HiddenIds;

HiddenIds::make('index-table')
```

> [!IMPORTANT]
> The table must contain an ID field.

<a name="use"></a>
## Usage

```php
use MoonShine\UI\Components\FlexibleRender;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\HiddenIds;
use MoonShine\UI\Components\FormBuilder;

//...
 
ActionButton::make('Active', route('moonshine.posts.mass-active', $this->uriKey()))
    ->inModal(fn () => 'Active', fn (): string => (string) FormBuilder::make(
        route('moonshine.posts.mass-active', $this->uriKey()),
        fields: [
            HiddenIds::make($this->listComponentName()), // the name of the component from which to get the ID
            FlexibleRender::make(__('moonshine::ui.confirm_message')),
        ]
    )
    ->async()
    ->submit('Active', ['class' => 'btn-secondary']))
    ->bulk(),
```