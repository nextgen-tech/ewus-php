# PHP eWUŚ

This package is PHP implementation of eWUŚ (Elektroniczna Weryfikacja Uprawnień Świadczeniobiorców). It has coded each available operation - login, logout, check patient status and change password. It is compliment with newest version (5.0), which contans additional information about patient (e.g. information about COVID-19 quarantine and isolation).

## ToC

1. [Requirements](#Requirements)
2. [Installation](#Installation)
3. [Usage](#Usage)

## Requirements

| Version |  PHP  |
| ------- | ----- |
|  0.0.1  | >=7.2 |

This package requires ext-dom to be installed on server. Optionally HTTP connection (via Guzzle) can be switched to native SOAP Client. In this case also ext-soap must be installed.

## Installation

```sh
composer require nextgen-tech/ewus
```

## Usage

```php
// Create once handler instance
$handler = new Handler(new HttpConnection());

// (Optional) Enable sandbox mode for testing
$handler->enableSandboxMode();

// Login
$request = new LoginRequest('15', 'TEST1', 'qwerty!@#');
$login = $handler->handle($request);

// Check patient status
$request = new CheckRequest($login->getSessionId(), $login->getToken(), '12345678901');
$check = $handler->handle($request);

// Change password
$request = new ChangePasswordRequest($login->getSessionId(), $login->getToken(), '15', 'TEST1', 'qwerty!@#', 'asdfgh#@!');
$changePassword = $handler->handle($request);

// Logout
$request = new LogoutRequest($login->getSessionId(), $login->getToken());
$logout = $handler->handle($request);
```
