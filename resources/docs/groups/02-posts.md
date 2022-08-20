# 02. Posts


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
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 5,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "冷傑",
                "email": "jgan@example.org",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Tenetur dignissimos nostrum ad. Et numquam qui tenetur esse ut omnis consequatur. Soluta et esse cumque. Illum eos deleniti alias iure vel eos.",
            "content": "Mollitia consequatur alias accusamus a rem. Explic...",
            "published_at": "2022-05-05 17:57:31",
            "slug": "tenetur-dignissimos-nostrum-ad-et-numquam-qui-tenetur-esse-ut-omnis-consequatur-soluta-et-esse-cumque-illum-eos-deleniti-alias-iure-vel-eos"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 5,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "冷傑",
                "email": "jgan@example.org",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Cumque doloremque repudiandae occaecati alias autem. Et velit rerum recusandae illum unde cupiditate est.",
            "content": "Ut sed eum odit distinctio aut. Rem id fugit conse...",
            "published_at": "2022-05-17 07:04:48",
            "slug": "cumque-doloremque-repudiandae-occaecati-alias-autem-et-velit-rerum-recusandae-illum-unde-cupiditate-est"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 3,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T14:43:09.000000Z",
                "name": "酈霖銘",
                "email": "ilu@example.com",
                "email_verified_at": "2022-05-23T04:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Officia omnis commodi quia adipisci eos. Quaerat quam maiores atque dolorem beatae omnis odio. Inventore quidem ut magnam pariatur alias ut ipsa. Aperiam in ratione libero expedita omnis nulla.",
            "content": "Reiciendis et laborum quia eaque. Dolorem et ducim...",
            "published_at": "2022-04-29 01:24:19",
            "slug": "officia-omnis-commodi-quia-adipisci-eos-quaerat-quam-maiores-atque-dolorem-beatae-omnis-odio-inventore-quidem-ut-magnam-pariatur-alias-ut-ipsa-aperiam-in-ratione-libero-expedita-omnis-nulla"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 3,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T14:43:09.000000Z",
                "name": "酈霖銘",
                "email": "ilu@example.com",
                "email_verified_at": "2022-05-23T04:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Deleniti culpa optio autem vel. Aut explicabo qui sint rerum ea natus inventore. Est omnis vel omnis sed voluptatem a deleniti. Culpa aut ut illum voluptatem voluptatum nobis.",
            "content": "Consequatur aliquam iste magnam quisquam consequat...",
            "published_at": "2022-04-25 20:13:56",
            "slug": "deleniti-culpa-optio-autem-vel-aut-explicabo-qui-sint-rerum-ea-natus-inventore-est-omnis-vel-omnis-sed-voluptatem-a-deleniti-culpa-aut-ut-illum-voluptatem-voluptatum-nobis"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 5,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "冷傑",
                "email": "jgan@example.org",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Non voluptatem laudantium officia id porro est. Officiis officiis tempore nemo qui. Ut et qui est accusamus minima.",
            "content": "Sed voluptatem praesentium autem omnis quo sunt pe...",
            "published_at": "2022-05-16 10:12:50",
            "slug": "non-voluptatem-laudantium-officia-id-porro-est-officiis-officiis-tempore-nemo-qui-ut-et-qui-est-accusamus-minima"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 3,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T14:43:09.000000Z",
                "name": "酈霖銘",
                "email": "ilu@example.com",
                "email_verified_at": "2022-05-23T04:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Et explicabo ut deleniti et nemo illo. Maxime ut nihil deleniti vitae porro. Quas voluptatem sint labore numquam aut sed.",
            "content": "Dicta quia ut distinctio velit ipsum placeat ipsum...",
            "published_at": "2022-05-18 07:50:07",
            "slug": "et-explicabo-ut-deleniti-et-nemo-illo-maxime-ut-nihil-deleniti-vitae-porro-quas-voluptatem-sint-labore-numquam-aut-sed"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 5,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "冷傑",
                "email": "jgan@example.org",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Autem odio consequuntur ut architecto placeat enim. Et adipisci eligendi ut fuga debitis qui dicta. Fugiat eveniet adipisci aut ut.",
            "content": "Qui asperiores consequatur harum aliquam rerum. Cu...",
            "published_at": "2022-05-14 01:54:51",
            "slug": "autem-odio-consequuntur-ut-architecto-placeat-enim-et-adipisci-eligendi-ut-fuga-debitis-qui-dicta-fugiat-eveniet-adipisci-aut-ut"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 1,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-24T14:11:09.000000Z",
                "name": "計廷",
                "email": "zsong@example.org",
                "email_verified_at": "2022-05-17T04:29:46.000000Z",
                "is_store": 0,
                "login_type_id": 1
            },
            "store_id": 2,
            "category_id": 2,
            "title": "Qui dolor alias voluptas consequatur. Facere sunt nostrum alias illum id itaque odio laboriosam. Neque eum officiis molestias mollitia est rerum.",
            "content": "Qui sunt aut excepturi dolor. Molestias nihil numq...",
            "published_at": "2022-04-25 00:17:38",
            "slug": "qui-dolor-alias-voluptas-consequatur-facere-sunt-nostrum-alias-illum-id-itaque-odio-laboriosam-neque-eum-officiis-molestias-mollitia-est-rerum"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 2,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "羊舌偉",
                "email": "yujia.ru@example.net",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 1,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Pariatur veritatis at nam quam ut aut aut. Nam iure vitae consequuntur architecto illum. Labore sed eaque hic id officiis accusamus cupiditate.",
            "content": "Eveniet voluptatem hic possimus possimus quo assum...",
            "published_at": "2022-05-04 07:17:12",
            "slug": "pariatur-veritatis-at-nam-quam-ut-aut-aut-nam-iure-vitae-consequuntur-architecto-illum-labore-sed-eaque-hic-id-officiis-accusamus-cupiditate"
        },
        {
            "created_at": "2022-05-23T12:29:46.000000Z",
            "user": {
                "id": 2,
                "created_at": "2022-05-23T12:29:46.000000Z",
                "updated_at": "2022-05-23T12:29:46.000000Z",
                "name": "羊舌偉",
                "email": "yujia.ru@example.net",
                "email_verified_at": "2022-05-23T12:29:46.000000Z",
                "is_store": 1,
                "login_type_id": 1
            },
            "store_id": 1,
            "category_id": 2,
            "title": "Magni magnam minus aspernatur. Beatae natus in sit soluta similique aut ea. Et consequatur quos quod eius beatae magnam. Magni voluptates deserunt reprehenderit et ab laboriosam.",
            "content": "Inventore qui quisquam qui laudantium accusantium....",
            "published_at": "2022-04-27 07:05:38",
            "slug": "magni-magnam-minus-aspernatur-beatae-natus-in-sit-soluta-similique-aut-ea-et-consequatur-quos-quod-eius-beatae-magnam-magni-voluptates-deserunt-reprehenderit-et-ab-laboriosam"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=2",
        "prev": null,
        "next": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
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
                "url": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http:\/\/ones-blog-api.test\/api\/posts?category_id=2&page=2",
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/posts",
        "per_page": 10,
        "to": 10,
        "total": 16
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
        "created_at": "2022-07-18T06:58:02.000000Z",
        "user": {
            "id": 34,
            "created_at": "2022-07-18T06:56:38.000000Z",
            "updated_at": "2022-07-18T06:57:03.000000Z",
            "name": "Han",
            "email": "han@gmail.com",
            "email_verified_at": "2022-07-18T06:57:03.000000Z",
            "is_store": 0,
            "login_type_id": 1
        },
        "store_id": 6,
        "category_id": 2,
        "title": "post",
        "content": "test",
        "published_at": null,
        "slug": "post"
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
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"location_id":6,"title":"Post","content":"Test","published_at":"2022-07-23T08:31:45.000000Z","active":true}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "location_id": 6,
    "title": "Post",
    "content": "Test",
    "published_at": "2022-07-23T08:31:45.000000Z",
    "active": true
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
    'http://ones-blog-api.test/api/posts',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'location_id' => 6,
            'title' => 'Post',
            'content' => 'Test',
            'published_at' => '2022-07-23T08:31:45.000000Z',
            'active' => true,
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
payload = {
    "location_id": 6,
    "title": "Post",
    "content": "Test",
    "published_at": "2022-07-23T08:31:45.000000Z",
    "active": true
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (201, when post created.):

```json
{
    "data": {
        "created_at": "2022-07-23T08:29:28.000000Z",
        "user": {
            "id": 34,
            "created_at": "2022-07-18T06:56:38.000000Z",
            "updated_at": "2022-07-18T15:02:00.000000Z",
            "name": "Han",
            "email": "han@gmail.com",
            "email_verified_at": "2022-07-18T06:57:03.000000Z",
            "is_store": 0,
            "login_type_id": 1
        },
        "store_id": 6,
        "category_id": 1,
        "title": "Post",
        "content": "Test",
        "published_at": null,
        "slug": "post"
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
        "user_id": [
            "{validation-error-message}"
        ],
        "store_id": [
            "{validation-error-message}"
        ],
        "category_id": [
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
<form id="form-POSTapi-posts" data-method="POST" data-path="api/posts" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts', this);">
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

</form>


## Update the specified post in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/posts/108" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"title":"0724Post","content":"0724Test","published_at":"20220724","active":true}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/108"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "title": "0724Post",
    "content": "0724Test",
    "published_at": "20220724",
    "active": true
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
    'http://ones-blog-api.test/api/posts/108',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'title' => '0724Post',
            'content' => '0724Test',
            'published_at' => '20220724',
            'active' => true,
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
payload = {
    "title": "0724Post",
    "content": "0724Test",
    "published_at": "20220724",
    "active": true
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when post updated.):

```json
{
    "data": {
        "created_at": "2022-07-23T08:31:45.000000Z",
        "user": {
            "id": 34,
            "created_at": "2022-07-18T06:56:38.000000Z",
            "updated_at": "2022-07-18T15:02:00.000000Z",
            "name": "Han",
            "email": "han@gmail.com",
            "email_verified_at": "2022-07-18T06:57:03.000000Z",
            "is_store": 0,
            "login_type_id": 1
        },
        "store_id": 1,
        "category_id": 3,
        "title": "0724Post",
        "content": "0724Test",
        "published_at": "2022-07-24 00:00:00",
        "slug": "0724post"
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
        "category_id": [
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
<form id="form-PUTapi-posts--post-" data-method="PUT" data-path="api/posts/{post}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-posts--post-', this);">
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

</form>


## Remove the specified post from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://ones-blog-api.test/api/posts/108" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/posts/108"
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
    'http://ones-blog-api.test/api/posts/108',
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

url = 'http://ones-blog-api.test/api/posts/108'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
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
<form id="form-DELETEapi-posts--post-" data-method="DELETE" data-path="api/posts/{post}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-posts--post-', this);">
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



