<x-page
    title="Вкладки"
    :sectionMenu="[
        'Разделы' => [
            ['url' => '#make', 'label' => 'Make'],
            ['url' => '#vertical-tab', 'label' => 'Вертикальные вкладки'],
            ['url' => '#active-tab', 'label' => 'Активная вкладка'],
            ['url' => '#tab-icon', 'label' => 'Иконка'],
            ['url' => '#tab-id', 'label' => 'ID вкладки'],
        ]
    ]"
>

<x-sub-title id="make">Make</x-sub-title>

<x-p>
    Компонент <em>Tabs</em> позволяет создавать вкладки.
</x-p>

<x-code language="php">
use MoonShine\Decorations\Tabs; // [tl! focus]
use MoonShine\Decorations\Tab; // [tl! focus]
use MoonShine\Fields\Text;

//...

public function components(): array
{
    return [
        Tabs::make([ // [tl! focus:1]
            Tab::make('Seo', [
                Text::make('Seo title')

                //...
            ]), // [tl! focus:1]
            Tab::make('Categories', [
                //...
            ])
        ]) // [tl! focus:-1]
    ];
}

//...
</x-code>

<x-image theme="light" src="{{ asset('screenshots/tabs.png') }}"></x-image>
<x-image theme="dark" src="{{ asset('screenshots/tabs_dark.png') }}"></x-image>

<x-sub-title id="vertical-tab">Вертикальное отображение вкладок.</x-sub-title>

<x-p>
    Метод <code>vertical()</code> позволяет отобразить вкладки в вертикальном режиме.
</x-p>

<x-code language="php">
vertical(Closure|bool|null $condition = null)
</x-code>

<x-code language="php">
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;

//...

public function components(): array
{
    return [
        Tabs::make([
            Tab::make('Seo', [
                //...
            ]),
            Tab::make('Categories', [
                //...
            ])

        ])->vertical() // [tl! focus]
    ];
}
//...
</x-code>

<x-image theme="light" src="{{ asset('screenshots/tabs_vertical.png') }}"></x-image>
<x-image theme="dark" src="{{ asset('screenshots/tabs_vertical_dark.png') }}"></x-image>

<x-p>
    По умолчанию минимальная ширина блока с вкладками, при котором происходит изменение их отображения в линию, равна <code>480px</code>. Изменить минимальное значение ширины можно через метод <code>customAttributes()</code>:
</x-p>
<x-code language="php">
    Tabs::make([
        //...
    ])
    ->customAttributes([ // [tl! focus]
        'data-tabs-vertical-min-width' => 600// [tl! focus]
    ]) // [tl! focus]

</x-code>

<x-sub-title id="active-tab">Активная вкладка</x-sub-title>

<x-p>
    Метод <code>active()</code> позволяет указать какая вкладка должна быть активной по умолчанию.
</x-p>

<x-code language="php">
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;

//...

public function components(): array
{
    return [
        Tabs::make([
            Tab::make('Seo', [
                //...
            ]),
            Tab::make('Categories', [
                //...
            ])
                ->active() // [tl! focus]
        ])
    ];
}

//...
</x-code>

<x-sub-title id="tab-icon">Иконка</x-sub-title>

<x-code language="php">
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;

//...

public function components(): array
{
    return [
        Tabs::make([
            Tab::make('Seo', [
                //...
            ]),
            Tab::make('Categories', [
                //...
            ])
                ->icon('heroicons.outline.pencil') // [tl! focus]
        ])
    ];
}

//...
</x-code>

<x-sub-title id="tab-id">ID вкладки</x-sub-title>

<x-p>
    Метод <code>uniqueId()</code> позволяет задать ID вкладки.<br />
    Таким образом можно реализовать свою логику для вкладок используя <strong>Alpine.js</strong>.
</x-p>

<x-code language="php">
uniqueId(string $id)
</x-code>

<x-code language="php">
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;

//...

public function components(): array
{
    return [
        Tabs::make([
            Tab::make('Tab 1', [
                //...

                ActionButton::make('Go to tab 2')->onClick(fn() => 'setActiveTab(`my-tab-2`)', 'prevent'),
            ])
                ->uniqueId('my-tab-1'), // [tl! focus]

            Tab::make('Tab 2', [
                //...

                ActionButton::make('Go to tab 1')->onClick(fn() => 'setActiveTab(`my-tab-1`)', 'prevent'),
            ])
                ->uniqueId('my-tab-2') // [tl! focus]
        ])
    ];
}

//...
</x-code>

<x-moonshine::grid>
    <x-moonshine::column adaptiveColSpan="12" colSpan="4">
        <x-moonshine::box class="flex items-center flex-wrap gap-4">
            {!!
                MoonShine\Decorations\Tabs::make([
                    MoonShine\Decorations\Tab::make('Tab 1', [
                        MoonShine\ActionButtons\ActionButton::make('Go to tab 2')->onClick(fn() => 'setActiveTab(`my-tab-2`)', 'prevent'),
                    ])
                        ->uniqueId('my-tab-1'), // [tl! focus]

                    MoonShine\Decorations\Tab::make('Tab 2', [
                        MoonShine\ActionButtons\ActionButton::make('Go to tab 1')->onClick(fn() => 'setActiveTab(`my-tab-1`)', 'prevent'),
                    ])
                        ->uniqueId('my-tab-2') // [tl! focus]
                ])
            !!}
        </x-moonshine::box>
    </x-moonshine::column>
</x-moonshine::grid>

</x-page>
