## Serve

```npm run dev```

```php artisan serve```

## Controller
### Index
For building filter
```
$filters = $this->filterSessions($request, 'THE PREFIX', [
    'keyword' => ''
]);
```

## Eloquent
### Index
Scope `->filterSort($filters)` for index sorting

## Vue
### Template
You can find Index and Edit template at `resources/js/Components/Clone`
