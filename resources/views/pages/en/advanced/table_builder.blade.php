@php use MoonShine\Fields\Text; @endphp

<x-page
    title="TableBuilder"
    :sectionMenu="[
        'Sections' => [
            ['url' => '#basics', 'label' => 'Basics'],
            ['url' => '#fields', 'label' => 'Fields'],
            ['url' => '#items', 'label' => 'Items'],
            ['url' => '#paginator', 'label' => 'Paginator'],
            ['url' => '#cast', 'label' => 'Casting'],
            ['url' => '#buttons', 'label' => 'Buttons'],
            ['url' => '#async', 'label' => 'Asynchronous mode'],
            ['url' => '#attributes', 'label' => 'Attributes'],
            ['url' => '#notfound', 'label' => 'Missing elements'],
            ['url' => '#simple', 'label' => 'Simplified style'],
            ['url' => '#sticky', 'label' => 'Sticky head'],
            ['url' => '#preview', 'label' => 'Preview'],
            ['url' => '#vertical', 'label' => 'Vertical mode'],
            ['url' => '#creatable', 'label' => 'Adding entries'],
            ['url' => '#editable', 'label' => 'Editable'],
            ['url' => '#sortable', 'label' => 'Sortable'],
            ['url' => '#column-display', 'label' => 'Column display'],
        ]
    ]"
>

<x-sub-title id="basics">Basics</x-sub-title>

<x-p>
    Fields and decorations in <strong>MoonShine</strong> are used inside tables in <code>preview</code> mode.<br/>
    <em>TableBuilder</em> is responsible for tables.<br/>
    Using <em>TableBuilder</em>, tables are displayed and filled with data.<br/>
    You can also use <em>TableBuilder</em> on your own pages or even outside of <strong>MoonShine</strong>.<br/>
</x-p>

<x-code language="php">
TableBuilder::make(
    Fields|array $fields = [],
    Paginator|iterable $items = [],
    ?Paginator $paginator = null
)
</x-code>

<x-ul>
    <li><code>$fields</code> - fields,</li>
    <li><code>$items</code> - field values</li>
    <li><code>$paginator</code> - paginator object.</li>
</x-ul>

<x-code language="php">
use MoonShine\Components\TableBuilder;

TableBuilder::make(
    [Text::make('Text')],
    [['text' => 'Value']]
)
</x-code>

<x-p>
    Same thing through methods:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([Text::make('Text')]) // [tl! focus]
    ->items([['text' => 'Value']]) // [tl! focus]
</x-code>

<x-p>
    Helper <code>table()</code> is also available:
</x-p>

<x-code language="php">
@{!!
    table() // [tl! focus]
        ->fields([Text::make('Text')])
        ->items([['text' => 'Value']])
!!}
</x-code>

{!!
    table()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])
!!}

<x-sub-title id="fields">Fields</x-sub-title>

<x-p>
    The <code>fields()</code> method allows you to specify a list of fields to build a table:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([
        Text::make('Text'),
    ]) // [tl! focus:-2]
</x-code>

<x-sub-title id="items">Items</x-sub-title>

<x-p>
    The <code>items()</code> method is used to fill the table with data:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([Text::make('Text')])
    ->items([['text' => 'Value']]) // [tl! focus]
</x-code>

<x-moonshine::alert type="default" icon="heroicons.information-circle">
    The correspondence of data with fields is carried out through the value
    <x-link link="{{ to_page('fields-index') }}#make">column</x-link>
    fields!
</x-moonshine::alert>

<x-sub-title id="paginator">Paginator</x-sub-title>

<x-p>
    The <code>paginator()</code> method for the table to work with pagination:
</x-p>

<x-code language="php">
$paginator = Article::paginate();

TableBuilder::make()
    ->fields([Text::make('Text')])
    ->items($paginator->items())
    ->paginator($paginator)  // [tl! focus]
</x-code>

Or directly pass the paginator:

<x-code language="php">
TableBuilder::make(
    items: Article::paginate()  // [tl! focus]
)
    ->fields([Text::make('Text')])
</x-code>

The <em>TableBuilder</em> works with arrays of items;<br/>

if you don't have arrays, you need to cast the paginator to arrays:

<x-code language="php">
$paginator = Article::paginate();

TableBuilder::make()
    ->fields([Text::make('Text')])
    ->items($paginator->through(fn ($item) => $item->toArray()))  // [tl! focus]
    ->paginator($paginator)
</x-code>

Or you can use <code>cast()</code> method instead.

<x-sub-title id="cast">Casting</x-sub-title>

<x-p>
    The <code>cast()</code> method is used to cast table values to a specific type.<br/>
    Since by default fields work with primitive types:
</x-p>

<x-code language="php">
use MoonShine\TypeCasts\ModelCast;

TableBuilder::make(items: User::paginate())
    ->fields([Text::make('Email')])
    ->cast(ModelCast::make(User::class)) // [tl! focus]
</x-code>

<x-p>
    In this example, we cast the data to the <code>User</code> model format using <code>ModelCast</code>.
</x-p>

<x-moonshine::alert type="default" icon="heroicons.book-open">
    For more detailed information, please refer to the section
    <x-link link="{{ to_page('advanced-type_casts') }}">TypeCasts</x-link>
</x-moonshine::alert>

<x-sub-title id="buttons">Buttons</x-sub-title>

<x-p>
    To add new buttons based on <em>ActionButton</em>, use the <code>buttons()</code> method.<br/>
    Buttons will be added for each row, and when <code>bulk()</code> mode is enabled, they will be displayed in the footer for bulk actions:
</x-p>

<x-code language="php">
TableBuilder::make(items: Article::paginate())
    ->fields([ID::make(), Switcher::make('Active')])
    ->cast(ModelCast::make(Article::class))
    ->buttons([
        ActionButton::make('Delete', route('name.delete')),
        ActionButton::make('Edit', route('name.edit'))->showInDropdown(),
        ActionButton::make('Go to home', route('home'))->blank()->canSee(fn($data) => $data->active),
        ActionButton::make('Mass Delete', route('name.mass_delete'))->bulk()
    ]) // [tl! focus:-5]
</x-code>

<x-sub-title id="async">Asynchronous mode</x-sub-title>

<x-p>
    If you need to receive data from the table asynchronously (during pagination, sorting),
    then use the <code>async()</code> method:
</x-p>

<x-code language="php">
async(
    ?string $asyncUrl = null,
    string|array|null $asyncEvents = null,
    ?string $asyncCallback = null
)
</x-code>

<x-ul>
    <li><code>asyncUrl</code> - request url</li>
    <li><code>asyncEvents</code> - events called after a successful request,</li>
    <li><code>asyncCallback</code> - js callback function after receiving a response.</li>
</x-ul>

<x-code language="php">
TableBuilder::make()
    ->async('/async_url') // [tl! focus]
</x-code>

<x-p>
    After a successful request, you can raise events by adding the <code>asyncEvents</code> parameter.
</x-p>

<x-code language="php">
    TableBuilder::make()
        ->name('crud')
        ->async(asyncEvents: ['table-updated-crud', 'form-reset-main-form']) // [tl! focus]
</x-code>

<x-p>
    <strong>MoonShine</strong> already has a set of ready-made events:
</x-p>

<x-ul>
    <li><code>table-updated-{name}</code> - updating an asynchronous table by its name</li>
    <li><code>form-reset-{name}</code> - reset the form values by its name,</li>
    <li><code>fragment-updated-{name}</code> - updating a blade fragment by its name.</li>
</x-ul>

<x-moonshine::alert type="warning" icon="heroicons.information-circle">
    The <code>async()</code> method must come after the <code>name()</code> method!
</x-moonshine::alert>

<x-sub-title id="attributes">Attributes</x-sub-title>

<x-p>
    You can set any html attributes for the table using the <code>customAttributes()</code> method:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->customAttributes(['class' => 'custom-table']) // [tl! focus]
</x-code>

<x-p>
    You can set any html attributes for table rows and cells:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->trAttributes(
        function(
            mixed $data,
            int $row,
            ComponentAttributeBag $attributes
        ): ComponentAttributeBag {
            return $attributes->merge(['class' => 'bgc-green']);
        }
    ) // [tl! focus:-8]
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])->trAttributes(function(mixed $data, int $row, $attributes) {
            return $attributes->merge(['class' => 'bgc-green']);
        })
!!}

<x-code language="php">
TableBuilder::make()
    ->tdAttributes(
        function(
            mixed $data,
            int $row,
            int $cell,
            ComponentAttributeBag $attributes
        ): ComponentAttributeBag {
            return $attributes->merge(['class' => 'bgc-red']);
        }
    ) // [tl! focus:-8]
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])->trAttributes(function(mixed $data, int $row, $attributes) {
            return $attributes->merge(['class' => 'bgc-red']);
        })
!!}

<x-sub-title id="notfound">Missing elements</x-sub-title>

<x-p>
    By default, if the table has no data, it will be empty,
    but you can display the message <em>"No records yet"</em>.<br/>
    To do this, use the <code>withNotFound()</code> method:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->withNotFound() // [tl! focus]
</x-code>

{!!
    table()
        ->fields([
            Text::make('Text')
        ])->withNotFound()
!!}

<x-sub-title id="simple">Simplified style</x-sub-title>

<x-p>
    By default, the table is styled as MoonShine,<br/>
    but using the <code>simple()</code> method you can display the table in a simplified style:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->simple() // [tl! focus]
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])->items([['text' => 'Value']])
!!}

<x-sub-title id="sticky">Sticky head</x-sub-title>

<x-p>
    The <code>sticky()</code> method allows you to fix the header when scrolling a table with a large number of elements.
</x-p>

<x-code language="php">
TableBuilder::make()
    ->sticky() // [tl! focus]
</x-code>

<x-sub-title id="preview">Preview</x-sub-title>

<x-p>
    The <code>preview()</code> method disables the display of buttons and sorts for the table:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->preview() // [tl! focus]
</x-code>

<x-sub-title id="vertical">Vertical mode</x-sub-title>
<x-p>
    Using the <code>vertical()</code> method you can display the table in vertical mode:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->vertical() // [tl! focus]
</x-code>

{!!
    table()
        ->vertical()
        ->fields([
            Text::make('Property 1', 'property_1'),
            Text::make('Property 2', 'property_2')
        ])
        ->items([
            ['property_2' => 'Value 2', 'property_1' => 'Value 1']
        ])
!!}

<x-sub-title id="creatable">Adding entries</x-sub-title>

<x-p>
    Using the <code>creatable()</code> method, you can create an "Add" button to generate new records in the table:
</x-p>

<x-code language="php">
creatable(
    bool $reindex = true,
    ?int $limit = null,
    ?string $label = null,
    ?string $icon = null,
    array $attributes = [],
    ?ActionButton $button = null
)
</x-code>

<x-ul>
    <li><code>$reindex</code> - editing mode with dynamic name,</li>
    <li><code>$limit</code> - the number of records that can be added</li>
    <li><code>$label</code> - button name</li>
    <li><code>$icon</code> - button icon</li>
    <li><code>$attributes</code> - additional attributes</li>
    <li><code>$button</code> - custom add button.</li>
</x-ul>

<x-code language="php">
TableBuilder::make()
    ->creatable(
        icon: 'heroicons.outline.pencil',
        attributes: ['class' => 'my-class']
    ) // [tl! focus:-4]
    ->fields([
        Text::make('Title'),
        Text::make('Text')
    ])->items([
        ['title' => 'Value 1', 'text' => 'Value 2'],
        ['title' => '', 'text' => '']
    ])
</x-code>

{!!
    table()
        ->creatable()
        ->fields([
            Text::make('Title'),
            Text::make('Text')
        ])->items([
            ['title' => 'Value 1', 'text' => 'Value 2'],
            ['title' => '', 'text' => '']
        ])
!!}

<x-p>
    <x-moonshine::alert type="default" icon="heroicons.information-circle">
        In append mode, the last element must be empty (the skeleton of the new entry)!
    </x-moonshine::alert>
</x-p>

<x-moonshine::divider label="reindex" />

<x-p>
    If the table contains fields in edit mode with a dynamic name,
    then you need to add a method or parameter <code>reindex</code>:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->creatable(reindex: true) // [tl! focus]
</x-code>

<x-p>
    or
</x-p>

<x-code language="php">
TableBuilder::make()
    ->creatable()
    ->reindex() // [tl! focus]
</x-code>

<x-moonshine::divider label="limit" />

<x-p>
    If you want to limit the number of records that can be added, you must specify the <code>limit</code> parameter:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->creatable(limit: 6) // [tl! focus]
</x-code>

<x-moonshine::divider label="Custom add button" />

<x-code language="php">
TableBuilder::make()
    ->creatable(
        button: ActionButton::make('Foo', '#')
    ) // [tl! focus:-2]
</x-code>

<x-sub-title id="editable">Editable</x-sub-title>

<x-p>
    By default, fields in the table are displayed in <code>preview</code> mode,<br/>
    but if you want to display them as editable form elements,<br/>
    then you need to use the <code>editable()</code> method:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->editable() // [tl! focus]
</x-code>

{!!
    table(items: [['title' => 'Value 1', 'text' => 'Value 2'], ['title' => '', 'text' => '']])
        ->creatable()
        ->reindex()
        ->editable()
        ->fields([
            Text::make('Title'),
            Text::make('Text')
        ])
!!}

<x-sub-title id="sortable">Sortable</x-sub-title>

<x-p>
    To sort rows in a table, use the <code>sortable()</code> method:
</x-p>

<x-code language="php">
sortable(
    ?string $url = null,
    string $key = 'id',
    ?string $group = null
)
</x-code>

<x-ul>
    <li><code>$url</code> - url handler</li>
    <li><code>$key</code> - element key</li>
    <li><code>$group</code> - grouping.</li>
</x-ul>

<x-code language="php">
TableBuilder::make()
    ->sortable(
        url: '/update_indexes_endpoint',
        key: 'id',
        group: 'nested'
    ) // [tl! focus:-4]
</x-code>

{!!
    table(items: [['title' => 'Value 1', 'text' => 'Value 2'], ['title' => 'Value 3', 'text' => 'Value 4']])
        ->sortable()
        ->fields([
            Text::make('Title'),
            Text::make('Text')
        ])
!!}

<x-sub-title id="column-display">Column display</x-sub-title>

<x-p>
    You can let users decide which columns to display in the table,
    saving the choice. To do this, you need to set the resource parameter <code>$columnSelection</code>.
</x-p>

<x-code language="php">
columnSelection(string $uniqueId = '')
</x-code>

<x-ul>
    <li><code>$uniqueId</code> - unique table Id to save the selection of displayed columns.</li>
</x-ul>

<x-code language="php">
TableBuilder::make()
    ->fields([
        Text::make('Title'),
        Text::make('Text')
    ])
    ->columnSelection('unique-id')
</x-code>

{!!
    table(items: [['title' => 'Value 1', 'text' => 'Value 2'], ['title' => 'Value 3', 'text' => 'Value 4']])
        ->sortable()
        ->fields([
            Text::make('Title'),
            Text::make('Text')
        ])
        ->columnSelection('unique-id')
!!}

<x-p>
    If you need to exclude fields from selection, use the <code>columnSelection()</code> method.
</x-p>

<x-code language="php">
public function columnSelection(bool $active = true)
</x-code>

<x-code>
TableBuilder::make()
    ->fields([
        Text::make('Title')
            ->columnSelection(false),
        Text::make('Text')
    ])
    ->columnSelection('unique-id')
</x-code>

{!!
    table(items: [['title' => 'Value 1', 'text' => 'Value 2'], ['title' => 'Value 3', 'text' => 'Value 4']])
        ->sortable()
        ->fields([
            Text::make('Title')
                ->columnSelection(false),
            Text::make('Text')
        ])
        ->columnSelection('unique-id')
!!}

</x-page>
