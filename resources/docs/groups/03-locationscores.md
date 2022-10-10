# 03. LocationScores


## Display a listing of the location scores.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/location-scores?location_id=3&user_id=31&limit=10&page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/location-scores"
);

let params = {
    "location_id": "3",
    "user_id": "31",
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
    'http://ones-blog-api.test/api/location-scores',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'query' => [
            'location_id'=> '3',
            'user_id'=> '31',
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

url = 'http://ones-blog-api.test/api/location-scores'
params = {
  'location_id': '3',
  'user_id': '31',
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


> Example response (200, when location scores displayed.):

```json
{
    "data": [
        {
            "user_id": "{user-id}",
            "location_id": "{location-id}",
            "score": "{location-score}"
        }
    ]
}
```
<div id="execution-results-GETapi-location-scores" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-location-scores"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-location-scores"></code></pre>
</div>
<div id="execution-error-GETapi-location-scores" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-location-scores"></code></pre>
</div>
<form id="form-GETapi-location-scores" data-method="GET" data-path="api/location-scores" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-location-scores', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/location-scores</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>location_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="location_id" data-endpoint="GETapi-location-scores" data-component="query"  hidden>
<br>
The id of the location.
</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="GETapi-location-scores" data-component="query"  hidden>
<br>
The id of the user.
</p>
<p>
<b><code>limit</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="limit" data-endpoint="GETapi-location-scores" data-component="query"  hidden>
<br>
The amount of results per page. Defaults to '10'.
</p>
<p>
<b><code>page</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="page" data-endpoint="GETapi-location-scores" data-component="query"  hidden>
<br>
The page of the results. Defaults to '1'.
</p>
</form>


## Store a newly created or update the specified location score in storage, or remove the specified location score from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/locations/5/location-scores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"score":3.8}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-scores"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "score": 3.8
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
    'http://ones-blog-api.test/api/locations/5/location-scores',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'score' => 3.8,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/locations/5/location-scores'
payload = {
    "score": 3.8
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when location score created, updated or deleted.):

```json
{
    "data": {
        "user_id": "{user-id}",
        "location_id": "{location-id}",
        "score": "{user-location-score}"
    }
}
```
> Example response (404, when location not found.):

```json
{
    "data": "Location(ID:{location-id}) is not found."
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
        "score": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-locations--location--location-scores" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-locations--location--location-scores"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-locations--location--location-scores"></code></pre>
</div>
<div id="execution-error-POSTapi-locations--location--location-scores" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-locations--location--location-scores"></code></pre>
</div>
<form id="form-POSTapi-locations--location--location-scores" data-method="POST" data-path="api/locations/{location}/location-scores" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-locations--location--location-scores', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/locations/{location}/location-scores</code></b>
</p>
<p>
<label id="auth-POSTapi-locations--location--location-scores" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-locations--location--location-scores" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="POSTapi-locations--location--location-scores" data-component="url" required  hidden>
<br>
The id of the location.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>score</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="score" data-endpoint="POSTapi-locations--location--location-scores" data-component="body" required  hidden>
<br>
The location score of the location, <b>0</b> for deleting.
</p>

</form>



