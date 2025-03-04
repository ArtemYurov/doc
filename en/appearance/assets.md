# Assets

- [Basics](#basics)
- [Asset Types](#asset-types)
- [Asset Collections](#asset-collections)
- [Asset Modification](#asset-modification)
- [Versioning](#versioning)
- [How to Add Assets](#how-to-add)
    - [Global](#global)
    - [Layout](#layout)
    - [CrudResource](#resource)
    - [Page](#page)
    - [Component](#component)
    - [Field](#field)

---

<a name="basics"></a>
## Basics

*AssetManager* in *MoonShine* provides a convenient way to manage *CSS* and *JavaScript* assets for your admin panel.
It supports various types of assets, including external files, inline code, and versioning.

<a name="asset-types"></a>
## Asset Types

In *MoonShine*, there are several types of assets:

- `MoonShine\AssetManager\Js` - js through `<script src>` tag
- `MoonShine\AssetManager\Css` - css through `<link>` tag
- `MoonShine\AssetManager\InlineCss` - css through `<style>` tag
- `MoonShine\AssetManager\InlineJs` - js through `<script>` tag
- `MoonShine\AssetManager\Raw` - arbitrary content in `head`

### JavaScript Files

```php
use MoonShine\AssetManager\Js;

// Basic inclusion
Js::make('/js/app.js')

// With deferred loading
Js::make('/js/app.js')->defer()

// With attributes
Js::make('/js/app.js')->customAttributes([
    'data-module' => 'main'
])
```

### CSS Files

```php
use MoonShine\AssetManager\Css;

// Basic inclusion
Css::make('/css/styles.css')

// With deferred loading
Css::make('/css/styles.css')->defer()

// With attributes
Css::make('/css/styles.css')->customAttributes([
    'media' => 'print'
])
```

### Inline JavaScript

```php
use MoonShine\AssetManager\InlineJs;

InlineJs::make(<<<JS
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Loaded");
    });
JS);
```

### Inline CSS

```php
use MoonShine\AssetManager\InlineCss;

InlineCss::make(<<<CSS
    .custom-class {
        color: red;
    }
CSS)
```

### Raw Content

```php
use MoonShine\AssetManager\Raw;

Raw::make('<link rel="preconnect" href="https://fonts.googleapis.com">')
```

<a name="asset-collections"></a>
## Asset Collections

*AssetManager* allows managing the loading order of assets. 
We recommend using DI to start interacting with *AssetManager*, for the service is responsible through the interface *MoonShine\Contracts\AssetManager\AssetManagerContract*.
Also, MoonShine provides convenient methods to interact with *AssetManager* in different entities such as *CrudResource*, *Page*, *Layout*, *Component*, *Field*

```php
// Add assets to the end
$assetManager->append([
    Js::make('/js/last.js')
]);

// Add assets to the beginning
$assetManager->prepend([
    Js::make('/js/first.js')
]);

// Add assets in the order of addition
$assetManager->add([
    Js::make('/js/middle.js')
]);
```

> [!TIP]
> You can also use the helper `moonshine()->getAssetManager()`

The *append* method will always add assets before the main list from *CrudResource*, *Page*, *Layout*, *Component*, *Field*, while *prepend* will add them after.
The *add* method will depend on the lifecycle of the application. Suppose you are adding assets to *ModelResource*,
but before the page is displayed, *Layout* will be called, which will also add assets, thus the assets from *Layout* will be added last.

<a name="asset-modification"></a>
## Asset Modification

You can modify the asset collection using closures:

```php
$assetManager->modifyAssets(function($assets) {
    // Modify the asset collection
    return array_filter($assets, function($asset) {
        return !str_contains($asset->getLink(), 'remove-this');
    });
});
```

<a name="versioning"></a>
## Versioning

*AssetManager* supports versioning of assets to manage caching, by default it will use the version of *MoonShine*, but you can override it for a specific asset:

```php
// Adding a version to an individual asset
Js::make('/js/app.js')->version('1.0.0')

// Result: /js/app.js?v=1.0.0
```

Versioning automatically adds a `v` parameter to the asset URL. If the URL already contains query parameters, the version will be added with `&`.

<a name="how-to-add"></a>
## How to Add Assets

<a name="global"></a>
### Global

```php
// MoonShineServiceProvider

public function boot(
    CoreContract $core,
    ConfiguratorContract $config,
    AssetManagerContract $assets,
): void
{
    $assets->add(Js::make('/js/app.js'));
}
```

<a name="layout"></a>
### Layout

```php
final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            Js::make(Vite::asset('resources/js/app.js'))
        ];
    }
}
```
<a name="resource"></a>
### CrudResource

```php
protected function onLoad(): void
{
    $this->getAssetManager()
        ->prepend(InlineJs::make('alert(1)'))
        ->append(Js::make('/js/app.js'));
}
```

<a name="page"></a>
### Page

```php
protected function onLoad(): void
{
    parent::onLoad();
    
    $this->getAssetManager()
        ->add(Css::make('/css/app.css'))
        ->append(Js::make('/js/app.js'));
}
```

<a name="component"></a>
### Component

#### On the Fly

```php
Box::make()->addAssets([
    Js::make('/js/custom.js'),
    Css::make('/css/styles.css')
]);
```

#### When Creating a Component

```php
final class MyComponent extends MoonShineComponent
{
    /**
     * @return list<AssetElementContract>
     */
    protected function assets(): array
    {
        return [
            Js::make('/js/custom.js'),
            Css::make('/css/styles.css')
        ];
    }
}
```

#### When Creating a Component via AssetManager

```php
final class MyComponent extends MoonShineComponent
{
    protected function booted(): void
    {
        parent::booted();
        
        $this->getAssetManager()
          ->add(Css::make('/css/app.css'))
          ->append(Js::make('/js/app.js'));
    }
}
```

<a name="field"></a>
### Field

The same as with *Component*, since *Field* is a component.
