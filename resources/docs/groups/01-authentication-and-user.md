# 01. Authentication and User


## Register a user with a personal access token for the device.




> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Han","email":"han@gmail.com","password":"123456","device_name":"iPhone"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Han",
    "email": "han@gmail.com",
    "password": "123456",
    "device_name": "iPhone"
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
    'http://ones-blog-api.test/api/register',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'Han',
            'email' => 'han@gmail.com',
            'password' => '123456',
            'device_name' => 'iPhone',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/register'
payload = {
    "name": "Han",
    "email": "han@gmail.com",
    "password": "123456",
    "device_name": "iPhone"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (201, when registration succeeded.):

```json
{
    "data": {
        "name": "{user-name}",
        "email": "{user-email}",
        "token": "{personal-access-token}"
    }
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "name": [
            "{validation-error-message}"
        ],
        "email": [
            "{validation-error-message}"
        ],
        "password": [
            "{validation-error-message}"
        ],
        "device_name": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-register"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
</div>
<div id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register"></code></pre>
</div>
<form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/register</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The password of the user.
</p>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The device name of the user.
</p>

</form>


## Verify a user with a code.




> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/verifyCode" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"hanTest@gmail.com","code":"VYB6P9"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/verifyCode"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "hanTest@gmail.com",
    "code": "VYB6P9"
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
    'http://ones-blog-api.test/api/verifyCode',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'hanTest@gmail.com',
            'code' => 'VYB6P9',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/verifyCode'
payload = {
    "email": "hanTest@gmail.com",
    "code": "VYB6P9"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when verify succeeded.):

```json
{
    "data": {
        "name": "{user-name}",
        "email": "{user-email}",
        "token": "{personal-access-token}"
    }
}
```
> Example response (422, when verify incorrect.):

```json
{
    "data": {
        "email": [
            "{validation-error-message}"
        ],
        "code": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-verifyCode" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-verifyCode"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-verifyCode"></code></pre>
</div>
<div id="execution-error-POSTapi-verifyCode" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-verifyCode"></code></pre>
</div>
<form id="form-POSTapi-verifyCode" data-method="POST" data-path="api/verifyCode" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-verifyCode', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/verifyCode</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-verifyCode" data-component="body" required  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="code" data-endpoint="POSTapi-verifyCode" data-component="body" required  hidden>
<br>
The code of the user.
</p>

</form>


## Login a user with a new personal access token for the device.




> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"han@gmail.com","password":"123456","device_name":"iPhone"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "han@gmail.com",
    "password": "123456",
    "device_name": "iPhone"
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
    'http://ones-blog-api.test/api/login',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'han@gmail.com',
            'password' => '123456',
            'device_name' => 'iPhone',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/login'
payload = {
    "email": "han@gmail.com",
    "password": "123456",
    "device_name": "iPhone"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when login succeeded.):

```json
{
    "data": {
        "name": "{user-name}",
        "email": "{user-email}",
        "token": "{personal-access-token}"
    }
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "email": [
            "{validation-error-message}"
        ],
        "password": [
            "{validation-error-message}"
        ],
        "device_name": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-login"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</div>
<div id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</div>
<form id="form-POSTapi-login" data-method="POST" data-path="api/login" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/login</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The password of the user.
</p>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The device name of the user.
</p>

</form>


## Update the specified user in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://ones-blog-api.test/api/users/34" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"name":"Han","email":"han@gmail.com","password":"1234567890"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/users/34"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "name": "Han",
    "email": "han@gmail.com",
    "password": "1234567890"
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
    'http://ones-blog-api.test/api/users/34',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'name' => 'Han',
            'email' => 'han@gmail.com',
            'password' => '1234567890',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/users/34'
payload = {
    "name": "Han",
    "email": "han@gmail.com",
    "password": "1234567890"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when user&#039;s information updated.):

```json
{
    "data": {
        "name": "{user-name}",
        "email": "{user-email}",
        "token": "{user-token}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
> Example response (404, when user not found.):

```json
{
    "data": "User(ID:{user-id}) is not found."
}
```
> Example response (422, when any validation failed.):

```json
{
    "data": {
        "email": [
            "{validation-error-message}"
        ],
        "password": [
            "{validation-error-message}"
        ]
    }
}
```
<div id="execution-results-PUTapi-users--user-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-users--user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--user-"></code></pre>
</div>
<div id="execution-error-PUTapi-users--user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--user-"></code></pre>
</div>
<form id="form-PUTapi-users--user-" data-method="PUT" data-path="api/users/{user}" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/users/{user}</code></b>
</p>
<p>
<label id="auth-PUTapi-users--user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-users--user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>user</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="user" data-endpoint="PUTapi-users--user-" data-component="url" required  hidden>
<br>
The id of the user.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-users--user-" data-component="body"  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-users--user-" data-component="body"  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="password" name="password" data-endpoint="PUTapi-users--user-" data-component="body"  hidden>
<br>
The password of the user.
</p>

</form>


## Logout a user with all the personal access tokens being revoked on the device.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://ones-blog-api.test/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "token: Bearer {personal-access-token}" \
    -d '{"device_name":"iPhone"}'

```

```javascript
const url = new URL(
    "http://ones-blog-api.test/api/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "token": "Bearer {personal-access-token}",
};

let body = {
    "device_name": "iPhone"
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
    'http://ones-blog-api.test/api/logout',
    [
        'headers' => [
            'Accept' => 'application/json',
            'token' => 'Bearer {personal-access-token}',
        ],
        'json' => [
            'device_name' => 'iPhone',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://ones-blog-api.test/api/logout'
payload = {
    "device_name": "iPhone"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'token': 'Bearer {personal-access-token}'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200, when logout succeeded.):

```json
{
    "data": {
        "name": "{user-name}",
        "email": "{user-email}",
        "token": "{personal-access-token}"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "data": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-logout"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"></code></pre>
</div>
<div id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout"></code></pre>
</div>
<form id="form-POSTapi-logout" data-method="POST" data-path="api/logout" data-authed="1" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json","token":"Bearer {personal-access-token}"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/logout</code></b>
</p>
<p>
<label id="auth-POSTapi-logout" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-logout" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-logout" data-component="body" required  hidden>
<br>
The device's name of the user.
</p>

</form>



