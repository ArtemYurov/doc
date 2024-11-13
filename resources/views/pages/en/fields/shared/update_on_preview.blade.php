<x-sub-title id="update-on-preview">Editing in preview</x-sub-title>

<x-p>
    The <code>updateOnPreview()</code> method allows you to edit the <em>{{ $field }}</em> field in <em>preview</em> mode.
</x-p>

<x-code language="php">
updateOnPreview(?Closure $url = null, ?ResourceContract $resource = null, mixed $condition = null)
</x-code>

<x-ul>
    <li><code>$url</code> - (optional) url for processing an asynchronous request,</li>
    <li><code>$resource</code> - (optional) model resource if the field is outside the resource</li>
    <li><code>$condition</code> - (optional) method execution condition.</li>
</x-ul>

<x-moonshine::alert type="default" icon="heroicons.information-circle">
    The settings are not required and must be passed if the field is running out of resource.
</x-moonshine::alert>

<x-code language="php">
use MoonShine\Fields\{{ $field }};

//...

public function fields(): array
{
    return [
        {{ $field }}::make({!! $field === 'Checkbox' ? 'Public' : 'Country' !!})
            ->updateOnPreview() // [tl! focus]
    ];
}

//...
</x-code>
