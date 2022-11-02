# 10. CityAreas


## Display the specified city area.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/city-areas/108" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/city-areas/108"
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
    'http://ones-blog-api.test/api/city-areas/108',
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

url = 'http://ones-blog-api.test/api/city-areas/108'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when city area displayed.):

```json
{
    "data": {
        "id": "{city-area-id}",
        "city": {
            "id": "{city-id}",
            "created_at": "{city-created-at}",
            "updated_at": "{city-updated-at}",
            "city": "{city-city}"
        },
        "city_area": "{city-area-city-area}"
    }
}
```
> Example response (404, when city area not found.):

```json
{
    "data": "CityArea(ID:{city-area-id}) is not found."
}
```
<div id="execution-results-GETapi-city-areas--city_area-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-city-areas--city_area-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-city-areas--city_area-"></code></pre>
</div>
<div id="execution-error-GETapi-city-areas--city_area-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-city-areas--city_area-"></code></pre>
</div>
<form id="form-GETapi-city-areas--city_area-" data-method="GET" data-path="api/city-areas/{city_area}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-city-areas--city_area-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/city-areas/{city_area}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>city_area</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="city_area" data-endpoint="GETapi-city-areas--city_area-" data-component="url" required  hidden>
<br>
The id of the city area.
</p>
</form>



