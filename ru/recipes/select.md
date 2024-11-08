# Select

В данном разделе мы собрали разные не стандартные подходы использования Select, которые вы можете модернизировать под свои нужды

## Async

```php
protected function formFields(): iterable
{
    return [
        Select::make('Select')->async(
            $this->getAsyncMethodUrl('selectOptions'),
        )->asyncOnInit(),
    ]
}

public function selectOptions(): MoonShineJsonResponse
{
    $options = new Options([
        new Option(label: 'Option 1', value: '1', selected: true, properties: new OptionProperty('https://cutcode.dev/images/platforms/youtube.png')),
        new Option(label: 'Option 2', value: '2', properties: new OptionProperty('https://cutcode.dev/images/platforms/youtube.png')),
    ]);

    return MoonShineJsonResponse::make(data: $options->toArray());
}
```

## Reactive

```php
Select::make('Company', 'company')->options([
    1 => 'Laravel',
    2 => 'CutCode',
    3 => 'Symfony',
])->reactive(function (FieldsContract $fields, mixed $value, Select $ctx, array $values): FieldsContract {
    $fields->findByColumn('dynamic_value')?->options((int) $value === 1 ? [
        4 => 4,
    ] : [2 => 2]);

    return $fields;
}),

Select::make('Dynamic value', 'dynamic_value')->options([4 => 4])->reactive(),
```

## ShowWhen

```php
Select::make('Company', 'company')->options([
    1 => 'Laravel',
    2 => 'CutCode',
    3 => 'Symfony',
]),
            
Select::make('Dynamic value', 'dynamic_value')
    ->setNameAttribute('dynamic_value_1')
    ->showWhen('company', '1')
    ->options([1 => 1, 2 => 2,]),
    
Select::make('Dynamic value', 'dynamic_value')
    ->setNameAttribute('dynamic_value_2')
    ->showWhen('company', '2')
    ->options([3 => 3, 4 => 4,]),
```

## onChangeMethod

```php
public function selectValues(): MoonShineJsonResponse
{
    $options = new Options([
        new Option('Option 1', '1', false, new OptionProperty('https://cutcode.dev/images/platforms/youtube.png')),
        new Option('Option 2', '2', true, new OptionProperty('https://cutcode.dev/images/platforms/youtube.png')),
    ]);

    return MoonShineJsonResponse::make()
        ->html(
            (string) Select::make('Next')->options($options)
        );
}

protected function formFields(): iterable
{
    return [
        Select::make('Select')->options([
            1 => 1,
            2 => 2,
        ])->onChangeMethod('selectValues', selector: '.next-select'),

        Div::make()->class('next-select'),
    ];
}
```

## Fragments

```php
protected function formFields(): iterable
{
    $selects = [];
    $value = request()->integer('_data.first', 1);

    if($value === 1) {
        $selects[] = Select::make('Second')->options([
            1 => 1,
            2 => 2,
        ]);
    }

    if($value === 2) {
        $selects[] = Select::make('Third')->options([
            1 => 1,
            2 => 2,
        ]);
    }

    return [
        Fragment::make([
            Select::make('First')->options([
                1 => 1,
                2 => 2,
            ])->setValue($value)->dispatchEvent(
                AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'selects')
            ),

            ...$selects,
        ])->name('selects'),
    ];
}
```