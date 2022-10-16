# 05. LocationLikes


## Display a listing of the location.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/location-likes?user_id=2&limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/location-likes"
);

let params = {
    "user_id": "2",
    "limit": "10",
    "page": "1",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://ones-blog-api.test/api/location-likes',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'query' => [
            'user_id'=> '2',
            'limit'=> '10',
            'page'=> '1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/location-likes'
params = {
  'user_id': '2',
  'limit': '10',
  'page': '1',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200, when location likes displayed.):

```json
{
    "data": [
        {
            "id": "{location-like-id}",
            "created_at": "{location-like-created-at}",
            "updated_at": "{location-like-updated-at}",
            "user_id": "{location-like-user-id}",
            "location_id": "{location-like-location-id}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/location-likes?page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/location-likes?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "pagination.previous",
                "active": false
            },
            {
                "url": "http:\/\/ones-blog-api.test\/api\/location-likes?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/location-likes",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
> Example response (200, when location likes displayed queried by user&#039;s id.):

```json
{
    "data": [
        {
            "user_id": "{location-user-id}",
            "city_area_id": "{location-city-area-id}",
            "category_id": "{location-category-id}",
            "name": "{location-name}",
            "address": "{location-address}",
            "phone": "{location-phone}",
            "avgScore": "{location-avgScore}",
            "introduction": "{location-introduction}",
            "active": "{location-active}",
            "images": "{location-images}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/location-likes?user_id=11&page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/location-likes?user_id=11&page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "pagination.previous",
                "active": false
            },
            {
                "url": "http:\/\/ones-blog-api.test\/api\/location-likes?user_id=11&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/location-likes",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-location-likes" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-location-likes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-location-likes"></code></pre>
</div>
<div id="execution-error-GETapi-location-likes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-location-likes"></code></pre>
</div>
<form id="form-GETapi-location-likes" data-method="GET" data-path="api/location-likes" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-location-likes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/location-likes</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="GETapi-location-likes" data-component="query"  hidden>
<br>
The id of the user.
</p>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-location-likes" data-component="query"  hidden>
<br>
The amount of results per page. Defaults to '10'.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-location-likes" data-component="query"  hidden>
<br>
The page of the results. Defaults to '1'.
</p>
</form>



