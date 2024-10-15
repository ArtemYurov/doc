# Метрики

На странице индекса модели ресурса вы можете отображать информационные блоки со статистикой - метрики. Для этого в методе `metrics()` верните массив из `Metric`.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\Laravel\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [
            ValueMetric::make('Articles')->value(fn() => Post::count()),
        ];
    }

    //...
}
```
![metrics](https://moonshine-laravel.com/screenshots/metrics.png)
![metrics_dark](https://moonshine-laravel.com/screenshots/metrics_dark.png)

> [!NOTE]
> Для более подробной информации, пожалуйста, обратитесь к разделам [Metrics](/docs/{{version}}/components/metrics)
