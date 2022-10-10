# 04. LocationServiceHours


## Display a listing of the location service hours.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/locations/5/location-service-hours" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-service-hours"
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
    'http://ones-blog-api.test/api/locations/5/location-service-hours',
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

url = 'http://ones-blog-api.test/api/locations/5/location-service-hours'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when location service hours displayed.):

```json
{
    "data": [
        {
            "location_id": "{location-service-hour-location-id}",
            "opened_at": "{location-service-hour-opened-at}",
            "closed_at": "{location-service-hour-closed-at}",
            "weekday": "{location-service-hour-weekday}"
        }
    ],
    "links": {
        "first": "http:\/\/ones-blog-api.test\/api\/locations\/6\/location-service-hours?page=1",
        "last": "http:\/\/ones-blog-api.test\/api\/locations\/6\/location-service-hours?page=1",
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
                "url": "http:\/\/ones-blog-api.test\/api\/locations\/6\/location-service-hours?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http:\/\/ones-blog-api.test\/api\/locations\/6\/location-service-hours",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```
<div id="execution-results-GETapi-locations--location--location-service-hours" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-locations--location--location-service-hours"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-locations--location--location-service-hours"></code></pre>
</div>
<div id="execution-error-GETapi-locations--location--location-service-hours" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-locations--location--location-service-hours"></code></pre>
</div>
<form id="form-GETapi-locations--location--location-service-hours" data-method="GET" data-path="api/locations/{location}/location-service-hours" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-locations--location--location-service-hours', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/locations/{location}/location-service-hours</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="GETapi-locations--location--location-service-hours" data-component="url" required  hidden>
<br>
The id of the location.
</p>
</form>


## Display the specified location service hour.




> Example request:

```bash
curl -X GET \
    -G "http://ones-blog-api.test/api/locations/5/location-service-hours/5" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-service-hours/5"
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
    'http://ones-blog-api.test/api/locations/5/location-service-hours/5',
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

url = 'http://ones-blog-api.test/api/locations/5/location-service-hours/5'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200, when location service hour displayed.):

```json
{
    "data": {
        "location_id": "{location-service-hour-location-id}",
        "opened_at": "{location-service-hour-opened-at}",
        "closed_at": "{location-service-hour-closed-at}",
        "weekday": "{location-service-hour-weekday}"
    }
}
```
> Example response (404, when location not found.):

```json
{
    "data": "Location(ID:{location-id}) is not found."
}
```
> Example response (404, when location service hour not found.):

```json
{
    "data": "LocationServiceHour(ID:{location-service-hour-id}) is not found."
}
```
<div id="execution-results-GETapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-locations--location--location-service-hours--location_service_hour-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<div id="execution-error-GETapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<form id="form-GETapi-locations--location--location-service-hours--location_service_hour-" data-method="GET" data-path="api/locations/{location}/location-service-hours/{location_service_hour}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-locations--location--location-service-hours--location_service_hour-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/locations/{location}/location-service-hours/{location_service_hour}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="GETapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
<p>
<b><code>location_service_hour</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location_service_hour" data-endpoint="GETapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location service hour.
</p>
</form>


## Store a newly created location service hour in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/locations/5/location-service-hours" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-service-hours"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://ones-blog-api.test/api/locations/5/location-service-hours',
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

url = 'http://ones-blog-api.test/api/locations/5/location-service-hours'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers)
response.json()
```


> Example response (201, when location service hours created.):

```json
{
    "data": {
        "location_id": "{location-service-hour-location-id}",
        "opened_at": "{location-service-hour-opened-at}",
        "closed_at": "{location-service-hour-closed-at}",
        "weekday": "{location-service-hour-weekday}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (403, when location service hour stored by wrong user.):

```json
{
    "data": "This action is unauthorized."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "weekday": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-locations--location--location-service-hours" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-locations--location--location-service-hours"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-locations--location--location-service-hours"></code></pre>
</div>
<div id="execution-error-POSTapi-locations--location--location-service-hours" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-locations--location--location-service-hours"></code></pre>
</div>
<form id="form-POSTapi-locations--location--location-service-hours" data-method="POST" data-path="api/locations/{location}/location-service-hours" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-locations--location--location-service-hours', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/locations/{location}/location-service-hours</code></b>
</p>
<p>
<label id="auth-POSTapi-locations--location--location-service-hours" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-locations--location--location-service-hours" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="POSTapi-locations--location--location-service-hours" data-component="url" required  hidden>
<br>
The id of the location.
</p>
</form>


## Update the specified location service hour in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/locations/5/location-service-hours/5" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-service-hours/5"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://ones-blog-api.test/api/locations/5/location-service-hours/5',
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

url = 'http://ones-blog-api.test/api/locations/5/location-service-hours/5'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers)
response.json()
```


> Example response (200, when location service hour updated.):

```json
{
    "data": {
        "location_id": "{location-service-hour-location-id}",
        "opened_at": "{location-service-hour-opened-at}",
        "closed_at": "{location-service-hour-closed-at}",
        "weekday": "{location-service-hour-weekday}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (403, when location service hour updated by wrong user.):

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
> Example response (404, when location service hour not found.):

```json
{
    "data": "LocationServiceHour(ID:{location-service-hour-id}) is not found."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "weekday": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-PUTapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-locations--location--location-service-hours--location_service_hour-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<div id="execution-error-PUTapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<form id="form-PUTapi-locations--location--location-service-hours--location_service_hour-" data-method="PUT" data-path="api/locations/{location}/location-service-hours/{location_service_hour}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-locations--location--location-service-hours--location_service_hour-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/locations/{location}/location-service-hours/{location_service_hour}</code></b>
</p>
<p>
<label id="auth-PUTapi-locations--location--location-service-hours--location_service_hour-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-locations--location--location-service-hours--location_service_hour-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="PUTapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
<p>
<b><code>location_service_hour</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location_service_hour" data-endpoint="PUTapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location service hour.
</p>
</form>


## Remove the specified location service hour from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://ones-blog-api.test/api/locations/5/location-service-hours/5" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}"
```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/locations/5/location-service-hours/5"
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
    'http://ones-blog-api.test/api/locations/5/location-service-hours/5',
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

url = 'http://ones-blog-api.test/api/locations/5/location-service-hours/5'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200, when location service hour deleted.):

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
> Example response (403, when location service hour deleted by wrong user.):

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
> Example response (404, when location service hour not found.):

```json
{
    "data": "LocationServiceHour(ID:{location-service-hour-id}) is not found."
}
```
<div id="execution-results-DELETEapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-locations--location--location-service-hours--location_service_hour-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<div id="execution-error-DELETEapi-locations--location--location-service-hours--location_service_hour-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-locations--location--location-service-hours--location_service_hour-"></code></pre>
</div>
<form id="form-DELETEapi-locations--location--location-service-hours--location_service_hour-" data-method="DELETE" data-path="api/locations/{location}/location-service-hours/{location_service_hour}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-locations--location--location-service-hours--location_service_hour-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/locations/{location}/location-service-hours/{location_service_hour}</code></b>
</p>
<p>
<label id="auth-DELETEapi-locations--location--location-service-hours--location_service_hour-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-locations--location--location-service-hours--location_service_hour-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>location</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location" data-endpoint="DELETEapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location.
</p>
<p>
<b><code>location_service_hour</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="location_service_hour" data-endpoint="DELETEapi-locations--location--location-service-hours--location_service_hour-" data-component="url" required  hidden>
<br>
The id of the location service hour.
</p>
</form>



