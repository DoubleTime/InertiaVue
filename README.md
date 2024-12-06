## Serve

```npm run dev```

```php artisan serve```

## Controller
### Index
For building filter
```
$filters = $this->filterSessions($request, 'THE PREFIX', [
    'keyword' => ''
```

## Eloquent
### Index
Scope `->filterSort($filters)` for index sorting

## Vue
### Template
You can find Index and Edit template at `resources/js/Components/Clone`

## Database
Switch between Mysql or MongoDB
At `App\Models\BaseModel.php` switch between use `App\Models\Model` and `use Moloquent`

## Develop Laravel Command 
php artisan make:controller ProductController --model=Product --resource

## Build For Release
1) Switch to release branch `git checkout release`
2) `npm run build`
3) .vue file will generate to public/build folder
