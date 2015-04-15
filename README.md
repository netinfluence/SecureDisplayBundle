# SecureDisplayBundle
NetinfluenceSecureDisplayBundle is a small simple bundle which protect emails and phone numbers behine encryption and JavaScript.

## Requirements
Before installing this bundle, you need to have a working installation of [FOSJsRoutingBundle](https://github.com/FriendsOfSymfony/FOSJsRoutingBundle).

## Installation

### Step 1: Composer
First you need to add `netinfluence/secure-display-bundle` to `composer.json`:

```json
{
   "require": {
        "netinfluence/secure-display-bundle": "dev-master"
    }
}
```
note: replace `dev-master` with the last version of this bundle.

### Step 2: AppKernel
```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Netinfluence\SecureDisplayBundle\NetinfluenceSecureDisplayBundle()
        );

        return $bundles;
    }
}
```

### Step 3: Config
```yaml
# app/config/config.yml
netinfluence_secure_display:
    key: "my_super_random_secure_key"
    # Optionally, you can customize used template here
    template: 'NetinfluenceSecureDisplayBundle::secure_display.html.twig'
```

### Step 4: Routing
```yaml
# app/config/routing.yml
netinfluence_secure_display:
    resource: "@NetinfluenceSecureDisplayBundle/Resources/config/routing.yml"
    prefix:   /
```


### Step 5: Assets
Publish assets
```sh
$ php app/console assets:install --symlink web
```
Add this line in your layout:

```jinja
<script src="{{ asset('bundles/netinfluencesecuredisplay/js/display.js') }}"></script>
```

## Usage
```twig
<h4>Here is my phone number</h4>

{# Default usage #}
{{ contact.phoneNumber|secureDisplay }}

{# Custom label when JavaScript is not enabled #}
{{ contact.phoneNumber|secureDisplay('this phone number is protected') }}

{# Transform phone number into clicable link #}
{{ contact.phoneNumber|secureDisplay(null, 'tel') }}    {# Can be 'tel', 'mailto', whatever you want #}

{# Custom html attributes #}
{{ contact.phoneNumber|secureDisplay(null, null, { 'style': 'color: red' }) }}
```

Of course, you cam mix any of these tree parameters as you want.
