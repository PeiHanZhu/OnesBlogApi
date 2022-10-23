# 06. Posts


## Display a listing of the posts.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/posts?category_id=2&limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts"
);

let params = {
    "category_id": "2",
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
    'http://ones-blog-api.test/api/posts',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'query' => [
            'category_id'=> '2',
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

url = 'http://ones-blog-api.test/api/posts'
params = {
  'category_id': '2',
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


> Example response (200, when posts displayed.):

```json
{
    "data": [
        {
            "id": "{post-id}",
            "user": {
                "id": "{user-id}",
                "created_at": "{user-created-at}",
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
            "created_at": "{post-created-at}",
            "slug": "{post-slug}",
            "images": "{post-images}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/posts",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-posts" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts"></code></pre>
</div>
<div id="execution-error-GETapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts"></code></pre>
</div>
<form id="form-GETapi-posts" data-method="GET" data-path="api/posts" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="category_id" data-endpoint="GETapi-posts" data-component="query"  hidden>
<br>
The id of the category.
</p>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-posts" data-component="query"  hidden>
<br>
The amount of results per page. Defaults to '10'.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-posts" data-component="query"  hidden>
<br>
The page of the results. Defaults to '1'.
</p>
</form>


## Display the specified post.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/posts/108" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/108"
);

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
    'http://ones-blog-api.test/api/posts/108',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/108'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when post displayed.):

```json
{
    "data": {
        "id": "{post-id}",
        "user": {
            "id": "{user-id}",
            "created_at": "{user-created-at}",
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
        "created_at": "{post-created-at}",
        "slug": "{post-slug}",
        "images": "{post-images}"
    }
}
```
> Example response (404, when post not found, inactive or unpublished.):

```json
{
    "data": "Post(ID:{post-id}) is not found."
}
```
<div id="execution-results-GETapi-posts--post-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--post-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--post-"></code></pre>
</div>
<div id="execution-error-GETapi-posts--post-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--post-"></code></pre>
</div>
<form id="form-GETapi-posts--post-" data-method="GET" data-path="api/posts/{post}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--post-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{post}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="GETapi-posts--post-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
</form>


## Store a newly created post in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/posts" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {personal-access-token}" \
    -F "location_id=6" \
    -F "title=Post" \
    -F "content=Test" \
    -F "published_at=2022-07-23T08:31:45.000000Z" \
    -F "active=1" \
    -F "images[]=@/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php0YsoUk" 
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Authorization": "Bearer {personal-access-token}",
};

const body = new FormData();
body.append('location_id', '6');
body.append('title', 'Post');
body.append('content', 'Test');
body.append('published_at', '2022-07-23T08:31:45.000000Z');
body.append('active', '1');
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://ones-blog-api.test/api/posts',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {personal-access-token}',
        ],
        'multipart' => [
            [
                'name' => 'location_id',
                'contents' => '6'
            ],
            [
                'name' => 'title',
                'contents' => 'Post'
            ],
            [
                'name' => 'content',
                'contents' => 'Test'
            ],
            [
                'name' => 'published_at',
                'contents' => '2022-07-23T08:31:45.000000Z'
            ],
            [
                'name' => 'active',
                'contents' => '1'
            ],
            [
                'name' => 'images[]',
                'contents' => fopen('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php0YsoUk', 'r')
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts'
files = {
  'images[]': open('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php0YsoUk', 'rb')
}
payload = {
    "location_id": 6,
    "title": "Post",
    "content": "Test",
    "published_at": "2022-07-23T08:31:45.000000Z",
    "active": true
}
headers = {
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json',
  'Authorization': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, files=files, data=payload)
response.json()
```


> Example response (201, when post created.):

```json
{
    "data": {
        "id": "{post-id}",
        "user": {
            "id": "{user-id}",
            "created_at": "{user-created-at}",
            "updated_at": "{user-updated-at}",
            "name": "{user-name}",
            "email": "{user-email}",
            "email_verified_at": "{user-email-verified-at}",
            "login_type_id": "{user-login-type-id}"
        },
        "location_id": "{post-location_id}",
        "title": "{post-title}",
        "content": "{post-content}",
        "published_at": "{post-published-at}",
        "created_at": "{post-created-at}",
        "slug": "{post-slug}",
        "images": "{post-images}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "location_id": [
            "{validation-error-message}"
        ],
        "title": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-posts" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-posts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-posts"></code></pre>
</div>
<div id="execution-error-POSTapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-posts"></code></pre>
</div>
<form id="form-POSTapi-posts" data-method="POST" data-path="api/posts" data-authed="1" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","Authorization":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/posts</code></b>
</p>
<p>
<label id="auth-POSTapi-posts" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-posts" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>location_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location_id" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The location of the post.
</p>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="title" data-endpoint="POSTapi-posts" data-component="body" required  hidden>
<br>
The title of the post.
</p>
<p>
<b><code>content</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="content" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The content of the post.
</p>
<p>
<b><code>published_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="published_at" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<br>
The published time of the post.
</p>
<p>
<b><code>active</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="active" value="true" data-endpoint="POSTapi-posts" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-posts" hidden><input type="radio" name="active" value="false" data-endpoint="POSTapi-posts" data-component="body" ><code>false</code></label>
<br>
The state of the post.
</p>
<p>
<b><code>images</code></b>&nbsp;&nbsp;<small>file[]</small>     <i>optional</i> &nbsp;
<input type="file" name="images.0" data-endpoint="POSTapi-posts" data-component="body"  hidden>
<input type="file" name="images.1" data-endpoint="POSTapi-posts" data-component="body" hidden>
<br>
The images of the post.
</p>

</form>


## Update the specified post in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/posts/108" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {personal-access-token}" \
    -F "title=0724Post" \
    -F "content=0724Test" \
    -F "published_at=20220724" \
    -F "active=1" \
    -F "_method=PUT" \
    -F "images[]=@/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php7wAzhp" 
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/108"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "Authorization": "Bearer {personal-access-token}",
};

const body = new FormData();
body.append('title', '0724Post');
body.append('content', '0724Test');
body.append('published_at', '20220724');
body.append('active', '1');
body.append('_method', 'PUT');
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://ones-blog-api.test/api/posts/108',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {personal-access-token}',
        ],
        'multipart' => [
            [
                'name' => 'title',
                'contents' => '0724Post'
            ],
            [
                'name' => 'content',
                'contents' => '0724Test'
            ],
            [
                'name' => 'published_at',
                'contents' => '20220724'
            ],
            [
                'name' => 'active',
                'contents' => '1'
            ],
            [
                'name' => '_method',
                'contents' => 'PUT'
            ],
            [
                'name' => 'images[]',
                'contents' => fopen('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php7wAzhp', 'r')
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/108'
files = {
  'images[]': open('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/php7wAzhp', 'rb')
}
payload = {
    "title": "0724Post",
    "content": "0724Test",
    "published_at": "20220724",
    "active": true,
    "_method": "PUT"
}
headers = {
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json',
  'Authorization': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers, files=files, data=payload)
response.json()
```


> Example response (200, when post updated.):

```json
{
    "data": {
        "id": "{post-id}",
        "user": {
            "id": "{user-id}",
            "created_at": "{user-created-at}",
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
        "created_at": "{post-created-at}",
        "slug": "{post-slug}",
        "images": "{post-images}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (404, when post not found.):

```json
{
    "data": "Post(ID:{post-id}) is not found."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "title": [
            "{validation-error-message}"
        ],
        "published_at": [
            "{validation-error-message}"
        ],
        "active": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-PUTapi-posts--post-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-posts--post-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-posts--post-"></code></pre>
</div>
<div id="execution-error-PUTapi-posts--post-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-posts--post-"></code></pre>
</div>
<form id="form-PUTapi-posts--post-" data-method="PUT" data-path="api/posts/{post}" data-authed="1" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","Authorization":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-posts--post-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/posts/{post}</code></b>
</p>
<p>
<label id="auth-PUTapi-posts--post-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-posts--post-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="PUTapi-posts--post-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="title" data-endpoint="PUTapi-posts--post-" data-component="body"  hidden>
<br>
The title of the post.
</p>
<p>
<b><code>content</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="content" data-endpoint="PUTapi-posts--post-" data-component="body"  hidden>
<br>
The content of the post.
</p>
<p>
<b><code>published_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="published_at" data-endpoint="PUTapi-posts--post-" data-component="body"  hidden>
<br>
The published time of the post.
</p>
<p>
<b><code>active</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-posts--post-" hidden><input type="radio" name="active" value="true" data-endpoint="PUTapi-posts--post-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-posts--post-" hidden><input type="radio" name="active" value="false" data-endpoint="PUTapi-posts--post-" data-component="body" ><code>false</code></label>
<br>
The state of the post.
</p>
<p>
<b><code>images</code></b>&nbsp;&nbsp;<small>file[]</small>     <i>optional</i> &nbsp;
<input type="file" name="images.0" data-endpoint="PUTapi-posts--post-" data-component="body"  hidden>
<input type="file" name="images.1" data-endpoint="PUTapi-posts--post-" data-component="body" hidden>
<br>
The images of the post.
</p>
<p>
<b><code>_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="_method" data-endpoint="PUTapi-posts--post-" data-component="body"  hidden>
<br>
Required if the <code><b>images</b></code> of the post are uploaded, must be <b>PUT</b> and request method must be <small class="badge badge-black">POST</small>.
</p>

</form>


## Remove the specified post from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://ones-blog-api.test/api/posts/108" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/108"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {personal-access-token}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://ones-blog-api.test/api/posts/108',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {personal-access-token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/108'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {personal-access-token}'
}

response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200, when post deleted.):

```json
{
    "data": "Success"
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (404, when post not found.):

```json
{
    "data": "Post(ID:{post-id}) is not found."
}
```
<div id="execution-results-DELETEapi-posts--post-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-posts--post-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-posts--post-"></code></pre>
</div>
<div id="execution-error-DELETEapi-posts--post-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-posts--post-"></code></pre>
</div>
<form id="form-DELETEapi-posts--post-" data-method="DELETE" data-path="api/posts/{post}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","Authorization":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-posts--post-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/posts/{post}</code></b>
</p>
<p>
<label id="auth-DELETEapi-posts--post-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-posts--post-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="DELETEapi-posts--post-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
</form>



