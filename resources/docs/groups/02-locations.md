# 02. Locations


## Display a listing of the locations.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/locations?category_id=2&city_id=11&random=1&ranking=6&limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations"
);

let params = {
    "category_id": "2",
    "city_id": "11",
    "random": "1",
    "ranking": "6",
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
    'http://ones-blog-api.test/api/locations',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'query' => [
            'category_id'=> '2',
            'city_id'=> '11',
            'random'=> '1',
            'ranking'=> '6',
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

url = 'http://ones-blog-api.test/api/locations'
params = {
  'category_id': '2',
  'city_id': '11',
  'random': '1',
  'ranking': '6',
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


> Example response (200, when locations displayed.):

```json
{
    "data": [
        {
            "user_id": "{user-id}",
            "city_area_id": "{city-area-id}",
            "category_id": "{category-id}",
            "name": "{location-name}",
            "address": "{location-address}",
            "phone": "{location-phone}",
            "avgScore": "{location-avgScore}",
            "introduction": "{location-introduction}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/locations?category_id=1&city_id=11&page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/locations?category_id=1&city_id=11&page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/locations?category_id=1&city_id=11&page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/locations",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-locations" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-locations"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-locations"></code></pre>
</div>
<div id="execution-error-GETapi-locations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-locations"></code></pre>
</div>
<form id="form-GETapi-locations" data-method="GET" data-path="api/locations" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-locations', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/locations</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="category_id" data-endpoint="GETapi-locations" data-component="query"  hidden>
<br>
The id of the category.
</p>
<p>
<b><code>city_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="city_id" data-endpoint="GETapi-locations" data-component="query"  hidden>
<br>
The id of the city.
</p>
<p>
<b><code>random</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="GETapi-locations" hidden><input type="radio" name="random" value="1" data-endpoint="GETapi-locations" data-component="query" ><code>true</code></label>
<label data-endpoint="GETapi-locations" hidden><input type="radio" name="random" value="0" data-endpoint="GETapi-locations" data-component="query" ><code>false</code></label>
<br>
Whether the results are in random order or not.
</p>
<p>
<b><code>ranking</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ranking" data-endpoint="GETapi-locations" data-component="query"  hidden>
<br>
The top amount of the results.
</p>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-locations" data-component="query"  hidden>
<br>
The amount of results per page. Defaults to '10'.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-locations" data-component="query"  hidden>
<br>
The page of the results. Defaults to '1'.
</p>
</form>


## Display the specified resource.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/locations/5" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5"
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
    'http://ones-blog-api.test/api/locations/5',
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

url = 'http://ones-blog-api.test/api/locations/5'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when location displayed.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "city_area_id": "{city-area-id}",
        "category_id": "{category-id}",
        "name": "{location-name}",
        "address": "{location-address}",
        "phone": "{location-phone}",
        "avgScore": "{location-avgScore}",
        "introduction": "{location-introduction}"
    }
}
```
> Example response (404, when location not found.):

```json
{
    "data": "Location(ID:{location-id}) is not found."
}
```
<div id="execution-results-GETapi-locations--location-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-locations--location-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-locations--location-"></code></pre>
</div>
<div id="execution-error-GETapi-locations--location-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-locations--location-"></code></pre>
</div>
<form id="form-GETapi-locations--location-" data-method="GET" data-path="api/locations/{location}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-locations--location-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/locations/{location}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="GETapi-locations--location-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/locations" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -F "city_area_id=153" \
    -F "category_id=2" \
    -F "name=新亞洲汽車" \
    -F "address=賢好街四段43巷434號75樓" \
    -F "phone=9110576179" \
    -F "introduction=Introduction" \
    -F "images[]=@/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpYPfR9Z" 
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

const body = new FormData();
body.append('city_area_id', '153');
body.append('category_id', '2');
body.append('name', '新亞洲汽車');
body.append('address', '賢好街四段43巷434號75樓');
body.append('phone', '9110576179');
body.append('introduction', 'Introduction');
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
    'http://ones-blog-api.test/api/locations',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'multipart' => [
            [
                'name' => 'city_area_id',
                'contents' => '153'
            ],
            [
                'name' => 'category_id',
                'contents' => '2'
            ],
            [
                'name' => 'name',
                'contents' => '新亞洲汽車'
            ],
            [
                'name' => 'address',
                'contents' => '賢好街四段43巷434號75樓'
            ],
            [
                'name' => 'phone',
                'contents' => '9110576179'
            ],
            [
                'name' => 'introduction',
                'contents' => 'Introduction'
            ],
            [
                'name' => 'images[]',
                'contents' => fopen('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpYPfR9Z', 'r')
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

url = 'http://ones-blog-api.test/api/locations'
files = {
  'images[]': open('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpYPfR9Z', 'rb')
}
payload = {
    "city_area_id": 153,
    "category_id": 2,
    "name": "\u65b0\u4e9e\u6d32\u6c7d\u8eca",
    "address": "\u8ce2\u597d\u8857\u56db\u6bb543\u5df7434\u865f75\u6a13",
    "phone": "9110576179",
    "introduction": "Introduction"
}
headers = {
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, files=files, data=payload)
response.json()
```


> Example response (201, when location created.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "city_area_id": "{city-area-id}",
        "category_id": "{category-id}",
        "name": "{location-name}",
        "address": "{location-address}",
        "phone": "{location-phone}",
        "avgScore": "{location-avgScore}",
        "introduction": "{location-introduction}"
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
        "city_area_id": [
            "{validation-error-message}"
        ],
        "category_id": [
            "{validation-error-message}"
        ],
        "name": [
            "{validation-error-message}"
        ],
        "address": [
            "{validation-error-message}"
        ],
        "phone": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-locations" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-locations"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-locations"></code></pre>
</div>
<div id="execution-error-POSTapi-locations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-locations"></code></pre>
</div>
<form id="form-POSTapi-locations" data-method="POST" data-path="api/locations" data-authed="1" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-locations', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/locations</code></b>
</p>
<p>
<label id="auth-POSTapi-locations" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-locations" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>city_area_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city_area_id" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
The city area of the location.
</p>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="category_id" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
The category of the location.
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
The name of the location.
</p>
<p>
<b><code>address</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="address" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
The address of the location.
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
The phone of the location.
</p>
<p>
<b><code>introduction</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="introduction" data-endpoint="POSTapi-locations" data-component="body"  hidden>
<br>
The introduction of the location.
</p>
<p>
<b><code>images</code></b>&nbsp;&nbsp;<small>file[]</small>     <i>optional</i> &nbsp;
<input type="file" name="images.0" data-endpoint="POSTapi-locations" data-component="body"  hidden>
<input type="file" name="images.1" data-endpoint="POSTapi-locations" data-component="body" hidden>
<br>
The images of the location.
</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/locations/5" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -F "city_area_id=153" \
    -F "category_id=2" \
    -F "name=統一娛樂" \
    -F "address=豐裡二路180巷804弄601號49樓" \
    -F "phone=1335933680" \
    -F "introduction=IntroductionTest" \
    -F "_method=PUT" \
    -F "images[]=@/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpKPpSlU" 
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

const body = new FormData();
body.append('city_area_id', '153');
body.append('category_id', '2');
body.append('name', '統一娛樂');
body.append('address', '豐裡二路180巷804弄601號49樓');
body.append('phone', '1335933680');
body.append('introduction', 'IntroductionTest');
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
    'http://ones-blog-api.test/api/locations/5',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'multipart' => [
            [
                'name' => 'city_area_id',
                'contents' => '153'
            ],
            [
                'name' => 'category_id',
                'contents' => '2'
            ],
            [
                'name' => 'name',
                'contents' => '統一娛樂'
            ],
            [
                'name' => 'address',
                'contents' => '豐裡二路180巷804弄601號49樓'
            ],
            [
                'name' => 'phone',
                'contents' => '1335933680'
            ],
            [
                'name' => 'introduction',
                'contents' => 'IntroductionTest'
            ],
            [
                'name' => '_method',
                'contents' => 'PUT'
            ],
            [
                'name' => 'images[]',
                'contents' => fopen('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpKPpSlU', 'r')
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

url = 'http://ones-blog-api.test/api/locations/5'
files = {
  'images[]': open('/private/var/folders/l6/2wvm3yyn1blbsd_4c3_s2kb80000gn/T/phpKPpSlU', 'rb')
}
payload = {
    "city_area_id": 153,
    "category_id": 2,
    "name": "\u7d71\u4e00\u5a1b\u6a02",
    "address": "\u8c50\u88e1\u4e8c\u8def180\u5df7804\u5f04601\u865f49\u6a13",
    "phone": "1335933680",
    "introduction": "IntroductionTest",
    "_method": "PUT"
}
headers = {
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers, files=files, data=payload)
response.json()
```


> Example response (200, when location displayed.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "city_area_id": "{city-area-id}",
        "category_id": "{category-id}",
        "name": "{location-name}",
        "address": "{location-address}",
        "phone": "{location-phone}",
        "avgScore": "{location-avgScore}",
        "introduction": "{location-introduction}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (403, when location updated by wrong user.):

```json
{
    "data": "This action is unauthorized."
}
```
> Example response (404, when location not found.):

```json
{
    "data": "Location(ID:{location-id}) is not found."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "city_area_id": [
            "{validation-error-message}"
        ],
        "category_id": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-PUTapi-locations--location-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-locations--location-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-locations--location-"></code></pre>
</div>
<div id="execution-error-PUTapi-locations--location-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-locations--location-"></code></pre>
</div>
<form id="form-PUTapi-locations--location-" data-method="PUT" data-path="api/locations/{location}" data-authed="1" data-hasfiles="1" data-headers='{"Content-Type":"multipart\/form-data","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-locations--location-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/locations/{location}</code></b>
</p>
<p>
<label id="auth-PUTapi-locations--location-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-locations--location-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="PUTapi-locations--location-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>city_area_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city_area_id" data-endpoint="PUTapi-locations--location-" data-component="body" required  hidden>
<br>
The city area of the location.
</p>
<p>
<b><code>category_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="category_id" data-endpoint="PUTapi-locations--location-" data-component="body" required  hidden>
<br>
The category of the location.
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-locations--location-" data-component="body" required  hidden>
<br>
The name of the location.
</p>
<p>
<b><code>address</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="address" data-endpoint="PUTapi-locations--location-" data-component="body" required  hidden>
<br>
The address of the location.
</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-locations--location-" data-component="body" required  hidden>
<br>
The phone of the location.
</p>
<p>
<b><code>introduction</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="introduction" data-endpoint="PUTapi-locations--location-" data-component="body"  hidden>
<br>
The introduction of the location.
</p>
<p>
<b><code>images</code></b>&nbsp;&nbsp;<small>file[]</small>     <i>optional</i> &nbsp;
<input type="file" name="images.0" data-endpoint="PUTapi-locations--location-" data-component="body"  hidden>
<input type="file" name="images.1" data-endpoint="PUTapi-locations--location-" data-component="body" hidden>
<br>
The images of the location.
</p>
<p>
<b><code>_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="_method" data-endpoint="PUTapi-locations--location-" data-component="body"  hidden>
<br>
Required if the <code><b>images</b></code> of the location are uploaded, must be <b>PUT</b> and request method must be <small class="badge badge-black">POST</small>.
</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://ones-blog-api.test/api/locations/5" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5"
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
    'http://ones-blog-api.test/api/locations/5',
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

url = 'http://ones-blog-api.test/api/locations/5'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200, when location deleted.):

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
> Example response (403, when location deleted by wrong user.):

```json
{
    "data": "This action is unauthorized."
}
```
> Example response (404, when location not found.):

```json
{
    "data": "Location(ID:{location-id}) is not found."
}
```
<div id="execution-results-DELETEapi-locations--location-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-locations--location-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-locations--location-"></code></pre>
</div>
<div id="execution-error-DELETEapi-locations--location-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-locations--location-"></code></pre>
</div>
<form id="form-DELETEapi-locations--location-" data-method="DELETE" data-path="api/locations/{location}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-locations--location-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/locations/{location}</code></b>
</p>
<p>
<label id="auth-DELETEapi-locations--location-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-locations--location-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="DELETEapi-locations--location-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
</form>



