# Search Module

*anomaly.module.search*

#### A MySQL based multilingual Scout driver with multi-model search support.

The Search Module provides a powerful MySQL-based search engine with Scout integration for PyroCMS applications.

## Features

- MySQL full-text search
- Multilingual support
- Multi-model searching
- Laravel Scout integration
- Searchable model support
- Configurable indexing
- Control panel interface

## Usage

### Making Models Searchable

```php
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'description' => $this->description
        ];
    }
}
```

### Performing Searches

```php
// Basic search
$results = Article::search('search term')->get();

// With pagination
$results = Article::search('search term')->paginate(15);

// Search across multiple models
use Anomaly\SearchModule\Search\SearchCriteria;

$criteria = new SearchCriteria();
$criteria->search('query text');
$results = $criteria->get();
```

### In Twig

```twig
{# Search form #}
<form action="/search" method="get">
    <input type="text" name="q" value="{{ request_get('q') }}">
    <button type="submit">Search</button>
</form>

{# Display results #}
{% for result in search(request_get('q')) %}
    <h3>{{ result.title }}</h3>
    <p>{{ result.excerpt }}</p>
{% endfor %}
```

## Requirements

- Streams Platform ^1.10
- PyroCMS 3.10+
- Laravel Scout

## License

The Search Module is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
