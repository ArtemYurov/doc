<x-page title="Quick Filters/Tags" :sectionMenu="[
    'Sections' => [
        ['url' => '#basics', 'label' => 'Basics'],
        ['url' => '#icon', 'label' => 'Icon'],
        ['url' => '#default', 'label' => 'Active item'],
        ['url' => '#can-see', 'label' => 'Display condition'],
        ['url' => '#alias', 'label' => 'URL Alias'],
    ]
]">

<x-sub-title id="basics">Basics</x-sub-title>

<x-p>
    Sometimes there is a need to create filters (results a selection) a set
    and display it on the listing. Tags have been created for such situations.
</x-p>

<x-code language="php">
namespace App\MoonShine\Resources;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\QueryTags\QueryTag; // [tl! focus]
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    public function queryTags(): array // [tl! focus:start]
    {
        return [
            QueryTag::make(
                'Post with author', // Tag Title
                fn(Builder $query) => $query->whereNotNull('author_id') // Query builder
            )
        ];
    } // [tl! focus:end] // [tl! focus:end]

    //...
}
</x-code>

<x-image theme="light" src="{{ asset('screenshots/query_tags.png') }}"></x-image>
<x-image theme="dark" src="{{ asset('screenshots/query_tags_dark.png') }}"></x-image>

<x-sub-title id="icon">Icon</x-sub-title>

<x-p>
    You can add an icon to a tag using the <code>icon()</code> method.
</x-p>

<x-code language="php">
use Illuminate\Database\Eloquent\Builder;
use MoonShine\QueryTags\QueryTag;

//...

QueryTag::make(
    'Post without an author',
    fn(Builder $query) => $query->whereNull('author_id')
)
    ->icon('heroicons.users') // [tl! focus]
</x-code>

<x-moonshine::alert type="default" icon="heroicons.book-open">
    For more detailed information, please refer to the section
    <x-link link="{{ to_page('icons') }}">Icons</x-link>
</x-moonshine::alert>

<x-sub-title id="default">Active item</x-sub-title>

<x-p>
    You can make <em>QueryTag</em> active by default.
    To do this, you need to use the <code>default()</code> method.
</x-p>

<x-code language="php">
default(Closure|bool|null $condition = null)
</x-code>

<x-code language="php">
use Illuminate\Database\Eloquent\Builder;
use MoonShine\QueryTags\QueryTag;

//...

QueryTag::make(
    'All posts',
    fn(Builder $query) => $query
)
    ->default() // [tl! focus]
</x-code>

<x-sub-title id="can-see">Display condition</x-sub-title>

<x-p>
    You may want to display tags only under certain conditions,
    To do this, you can use the <code>canSee()</code> method,
    which needs to pass a callback function that returns <code>TRUE</code> or <code>FALSE</code>.
</x-p>

<x-code language="php">
use Illuminate\Database\Eloquent\Builder;
use MoonShine\QueryTags\QueryTag;

//...

QueryTag::make(
    'Post with author', // Tag title
    fn(Builder $query) => $query->whereNotNull('author_id')
)
    ->canSee(fn() => auth()->user()->moonshine_user_role_id === 1) // [tl! focus]
</x-code>

<x-sub-title id="alias">Alias</x-sub-title>

<x-p>
    By default, the value for the URL is generated automatically from the <em>label</em> parameter.
    In this case, all non-Latin alphabet characters are replaced with the corresponding transliteration
    <code>'Заголовок' => 'zagolovok'</code>.
</x-p>

<x-p>
    The <code>alias()</code> method allows you to set your own value for the URL.
</x-p>

<x-code language="php">
use Illuminate\Database\Eloquent\Builder;
use MoonShine\QueryTags\QueryTag;

//...

QueryTag::make(
    'Archived Posts',
    fn(Builder $query) => $query->where('is_archived', true)
)
    ->alias('archive') // [tl! focus]
</x-code>

</x-page>
