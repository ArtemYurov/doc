# Установка

- [Требования](#requirements)
- [Установка через composer](#composer)
- [Установка панели](#install)

---

<a name="requirements"></a>
## Требования

Для работы с MoonShine необходимо выполнение следующих требований перед установкой:

- PHP 8.2+
- Laravel 10.48+
- Composer 2+

<a name="composer"></a>
## Установка через Composer

```shell
composer require "moonshine/moonshine:^3.0"
```

<a name="install"></a>
## Установка панели

```shell
php artisan moonshine:install
```
> [!TIP]
> Выполняйте установку единожды на старте, после установки все можно настроить через [конфигурацию](/docs/{{version}}/configuration)

В процессе установки вам будет предложено выполнить:

1. *Аутентификация*. Включить/выключить `middleware` с проверкой есть ли доступ у пользователя к панели.
2. *Миграции*. Необходимы, если вы решите использовать встроенные возможности `MoonShine` для управления пользователями и ролями.
3. *Уведомления*. Включить/выключить систему уведомлений, также будет предложено использовать или нет драйвер базы данных, для хранения уведомлений в базе данных
4. *Тема шаблона*. Стандартная или компактная
5. *Суперпользователь*. Если вы выбрали вариант с миграциями, вам предложат создать суперпользователя, который получит доступ в административную панель с указанными при установке данными.
6. *Не забудьте поставить звезду GitHub репозиторию. Спасибо!*

В процессе установки будет добавлено и выполнено:

- `php artisan storage:link`
- `app/Providers/MoonShineServiceProvider.php`, а также провайдер будет добавлен в `bootstrap/providers.php`
- `app/MoonShine`
- `config/moonshine.php`
- `lang/vendor/moonshine`
- `public/vendor/moonshine`
- `app/MoonShine/Pages/Dashboard.php`
- `app/MoonShine/Layouts/MoonShineLayout.php`

После установки проект будет иметь следующую структуру:

- `app/MoonShine` — основная директория с ресурсами, страницами и шаблонами страниц.
    - `app/MoonShine/Pages` — основа MoonShine — это страницы. Каждый роут в админ-панели рендерит страницу с набором компонентов. Если несколько страниц объединены одной задачей, их можно сгруппировать в ресурсы.
    - `app/MoonShine/Resources` — ресурсы используются для логической группировки страниц. Если речь идет о `ModelResource` (CrudResource), такие ресурсы сразу включают в себя полный функционал для операций CRUD и все необходимые страницы для создания, редактирования, просмотра и списка записей.
    - `app/MoonShine/Layouts/MoonShineLayout.php` — основной шаблон для всех страниц. Здесь можно изменить структуру компонентов, внешний вид и меню. Можно создавать любое количество шаблонов и выбирать нужный для каждой страницы.
- `app/Providers/MoonShineServiceProvider.php` — в этом провайдере регистрируются ресурсы и страницы, а также указываются глобальные настройки. Панель можно конфигурировать как через удобный объект в провайдере, так и через файл `config/moonshine.php`.
- `config/moonshine.php` — файл с основными настройками MoonShine. Можно оставить в нем только измененные ключи или вовсе удалить файл, настроив всё через `MoonShineServiceProvider`.

Теперь всё готово для использования и создания вашей административной панели. Вы уже можете получить к ней доступ по адресу `/admin`.

Рекомендуем вам следовать документации шаг за шагом, чтобы глубже разобраться в концепции. Следующий раздел — **Конфигурация**, где вы также найдете ответы как быть если выбрали путь собственной реализации аутентификации и сущности пользователей.
