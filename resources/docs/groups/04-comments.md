# 04. Comments


## Display a listing of the comments.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/posts/109/comments?limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/109/comments"
);

let params = {
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
    'http://ones-blog-api.test/api/posts/109/comments',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'query' => [
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

url = 'http://ones-blog-api.test/api/posts/109/comments'
params = {
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


> Example response (200, when comments displayed.):

```json
{
    "data": [
        {
            "user_id": "{user-id}",
            "post_id": "{post-id}",
            "content": "{content}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/posts\/109\/comments?page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/posts\/109\/comments?page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/posts\/109\/comments?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/posts\/109\/comments",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-posts--post--comments" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--post--comments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--post--comments"></code></pre>
</div>
<div id="execution-error-GETapi-posts--post--comments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--post--comments"></code></pre>
</div>
<form id="form-GETapi-posts--post--comments" data-method="GET" data-path="api/posts/{post}/comments" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--post--comments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{post}/comments</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="GETapi-posts--post--comments" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-posts--post--comments" data-component="query"  hidden>
<br>
The amount of results per page.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-posts--post--comments" data-component="query"  hidden>
<br>
The page of the results.
</p>
</form>


## Display the specified comment.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/posts/109/comments/33" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/109/comments/33"
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
    'http://ones-blog-api.test/api/posts/109/comments/33',
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

url = 'http://ones-blog-api.test/api/posts/109/comments/33'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when comment displayed.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "post_id": "{post-id}",
        "content": "{content}"
    }
}
```
> Example response (404, when post not found.):

```json
{
    "data": "Post(ID:{post-id}) is not found."
}
```
> Example response (404, when comment not found.):

```json
{
    "data": "Comment(ID:{comment-id}) is not found."
}
```
<div id="execution-results-GETapi-posts--post--comments--comment-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-posts--post--comments--comment-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--post--comments--comment-"></code></pre>
</div>
<div id="execution-error-GETapi-posts--post--comments--comment-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--post--comments--comment-"></code></pre>
</div>
<form id="form-GETapi-posts--post--comments--comment-" data-method="GET" data-path="api/posts/{post}/comments/{comment}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--post--comments--comment-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/posts/{post}/comments/{comment}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="GETapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="comment" data-endpoint="GETapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the comment.
</p>
</form>


## Store a newly created comment in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/posts/109/comments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"content":"commentTest"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/109/comments"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "content": "commentTest"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://ones-blog-api.test/api/posts/109/comments',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'content' => 'commentTest',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/109/comments'
payload = {
    "content": "commentTest"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (201, when comment created.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "post_id": "{post-id}",
        "content": "{content}"
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
        "content": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-posts--post--comments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-posts--post--comments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-posts--post--comments"></code></pre>
</div>
<div id="execution-error-POSTapi-posts--post--comments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-posts--post--comments"></code></pre>
</div>
<form id="form-POSTapi-posts--post--comments" data-method="POST" data-path="api/posts/{post}/comments" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts--post--comments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/posts/{post}/comments</code></b>
</p>
<p>
<label id="auth-POSTapi-posts--post--comments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-posts--post--comments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="POSTapi-posts--post--comments" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>content</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="content" data-endpoint="POSTapi-posts--post--comments" data-component="body"  hidden>
<br>
The content of the comment.
</p>

</form>


## Update the specified comment in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/posts/109/comments/32" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"content":"0724Comment"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/109/comments/32"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "content": "0724Comment"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://ones-blog-api.test/api/posts/109/comments/32',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'content' => '0724Comment',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/109/comments/32'
payload = {
    "content": "0724Comment"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when comment updated.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "post_id": "{post-id}",
        "content": "{content}"
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
> Example response (404, when comment not found.):

```json
{
    "data": "Comment(ID:{comment-id}) is not found."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "content": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-PUTapi-posts--post--comments--comment-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-posts--post--comments--comment-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-posts--post--comments--comment-"></code></pre>
</div>
<div id="execution-error-PUTapi-posts--post--comments--comment-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-posts--post--comments--comment-"></code></pre>
</div>
<form id="form-PUTapi-posts--post--comments--comment-" data-method="PUT" data-path="api/posts/{post}/comments/{comment}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-posts--post--comments--comment-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/posts/{post}/comments/{comment}</code></b>
</p>
<p>
<label id="auth-PUTapi-posts--post--comments--comment-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-posts--post--comments--comment-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="PUTapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="comment" data-endpoint="PUTapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the comment.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>content</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="content" data-endpoint="PUTapi-posts--post--comments--comment-" data-component="body" required  hidden>
<br>
The content of the comment.
</p>

</form>


## Remove the specified comment from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://ones-blog-api.test/api/posts/109/comments/16" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/109/comments/16"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://ones-blog-api.test/api/posts/109/comments/16',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/posts/109/comments/16'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200, when comment deleted.):

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
> Example response (404, when comment not found.):

```json
{
    "data": "Comment(ID:{comment-id}) is not found."
}
```
<div id="execution-results-DELETEapi-posts--post--comments--comment-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-posts--post--comments--comment-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-posts--post--comments--comment-"></code></pre>
</div>
<div id="execution-error-DELETEapi-posts--post--comments--comment-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-posts--post--comments--comment-"></code></pre>
</div>
<form id="form-DELETEapi-posts--post--comments--comment-" data-method="DELETE" data-path="api/posts/{post}/comments/{comment}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-posts--post--comments--comment-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/posts/{post}/comments/{comment}</code></b>
</p>
<p>
<label id="auth-DELETEapi-posts--post--comments--comment-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-posts--post--comments--comment-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>post</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="post" data-endpoint="DELETEapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the post.
</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="comment" data-endpoint="DELETEapi-posts--post--comments--comment-" data-component="url" required  hidden>
<br>
The id of the comment. Exmaple: 32
</p>
</form>



