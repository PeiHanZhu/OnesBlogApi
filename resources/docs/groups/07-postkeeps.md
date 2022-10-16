# 07. PostKeeps


## Display a listing of the post.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/post-keeps?user_id=2&limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/post-keeps"
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
    'http://ones-blog-api.test/api/post-keeps',
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

url = 'http://ones-blog-api.test/api/post-keeps'
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


> Example response (200, when post keeps displayed.):

```json
{
    "data": [
        {
            "id": "{post-keep-id}",
            "created_at": "{post-keep-created-at}",
            "updated_at": "{post-keep-updated-at}",
            "user_id": "{post-keep-user-id}",
            "post_id": "{post-keep-post-id}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/post-keeps?page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/post-keeps?page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/post-keeps?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/post-keeps",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
> Example response (200, when post keeps displayed queried by user&#039;s id.):

```json
{
    "data": [
        {
            "created_at": "{post-created-at}",
            "user": {
                "id": "{user-id}",
                "created_at": "{user-created_at}",
                "updated_at": "{user-updated-at}",
                "name": "{user-name}",
                "email": "{user-email}",
                "email_verified_at": "{user-email-verified-at}",
                "login_type_id": "{user-login-type-id}"
            },
            "location_id": "{post-location-id}",
            "title": "{post-title}",
            "content": "{post-content}",
            "published_at": "{post-published-at}",
            "active": "{post-active}",
            "slug": "{post-slug}",
            "images": "{post-images}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/post-keeps?user_id=12&page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/post-keeps?user_id=12&page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/post-keeps?user_id=12&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/post-keeps",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-post-keeps" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-post-keeps"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-post-keeps"></code></pre>
</div>
<div id="execution-error-GETapi-post-keeps" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-post-keeps"></code></pre>
</div>
<form id="form-GETapi-post-keeps" data-method="GET" data-path="api/post-keeps" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-post-keeps', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/post-keeps</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="GETapi-post-keeps" data-component="query"  hidden>
<br>
The id of the user.
</p>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-post-keeps" data-component="query"  hidden>
<br>
The amount of results per page. Defaults to '10'.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-post-keeps" data-component="query"  hidden>
<br>
The page of the results. Defaults to '1'.
</p>
</form>



