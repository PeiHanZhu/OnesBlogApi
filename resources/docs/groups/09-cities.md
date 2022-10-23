# 09. Cities


## Display a listing of the cities.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/cities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/cities"
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
    'http://ones-blog-api.test/api/cities',
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

url = 'http://ones-blog-api.test/api/cities'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when cities displayed.):

```json
{
    "data": [
        {
            "id": "{city-id}",
            "created_at": "{city-created-at}",
            "updated_at": "{city-updated-at}",
            "city": "{city-city}"
        }
    ]
}
```
<div id="execution-results-GETapi-cities" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cities"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cities"></code></pre>
</div>
<div id="execution-error-GETapi-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cities"></code></pre>
</div>
<form id="form-GETapi-cities" data-method="GET" data-path="api/cities" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cities', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cities</code></b>
</p>
</form>


## Display the specified city.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/cities/20" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/cities/20"
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
    'http://ones-blog-api.test/api/cities/20',
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

url = 'http://ones-blog-api.test/api/cities/20'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when city displayed.):

```json
{
    "data": {
        "id": "{city-id}",
        "created_at": "{city-created-at}",
        "updated_at": "{city-updated-at}",
        "city": "{city-city}",
        "city_areas": [
            {
                "id": "{city-area-id}",
                "created_at": "{city-area-created-at}",
                "updated_at": "{city-area-updated-at}",
                "city_id": "{city-area-city-id}",
                "city_area": "{city-area-city-area}",
                "zip_code": "{city-area-zip-code}"
            }
        ]
    }
}
```
> Example response (404, when city not found.):

```json
{
    "data": "City(ID:{city-id}) is not found."
}
```
<div id="execution-results-GETapi-cities--city-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cities--city-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cities--city-"></code></pre>
</div>
<div id="execution-error-GETapi-cities--city-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cities--city-"></code></pre>
</div>
<form id="form-GETapi-cities--city-" data-method="GET" data-path="api/cities/{city}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cities--city-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cities/{city}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>city</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city" data-endpoint="GETapi-cities--city-" data-component="url" required  hidden>
<br>
The id of the city.
</p>
</form>



