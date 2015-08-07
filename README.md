# SecureDisplayBundle
NetinfluenceSecureDisplayBundle is a small simple bundle which protect emails, phone numbers and any text you want from spam bot, by using encryption, ajax and JavaScript.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6cc91472-5916-44b7-b5f7-886e6105e8bd/big.png)](https://insight.sensiolabs.com/projects/6cc91472-5916-44b7-b5f7-886e6105e8bd)
[![knpbundles.com](http://knpbundles.com/netinfluence/SecureDisplayBundle/badge)](http://knpbundles.com/netinfluence/SecureDisplayBundle)
[![Build Status](https://travis-ci.org/netinfluence/SecureDisplayBundle.svg?branch=master)](https://travis-ci.org/netinfluence/SecureDisplayBundle)


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
Register the bundle into the Symfony AppKernel
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
Define the configuration of the bundle into the config file
```yaml
# app/config/config.yml
netinfluence_secure_display:
    # Required, key used to encrypt data
    key: "my_super_random_secure_key"
    # Optional, you can customize used template here
    template: 'NetinfluenceSecureDisplayBundle::secure_display.html.twig'
```

### Step 4: Routing
Register the routing of the bundle to be able to perform ajax requests
```yaml
# app/config/routing.yml
netinfluence_secure_display:
    resource: "@NetinfluenceSecureDisplayBundle/Resources/config/routing.yml"
    prefix:   /
```


### Step 5: Assets
Publish the assets to be able to use the javascript file
```sh
$ php app/console assets:install --symlink web
```
Add this line in your layout:

```jinja
<script src="{{ asset('bundles/netinfluencesecuredisplay/js/display.js') }}"></script>
```

## Declaration
```twig
{{ some.data|secureDisplay(label, action, attributes) }}
```
parameters
- label: optional
   - type: string
   - value: text to display if the javascript is not enabled
- action: optional
   - type: string
   - value: action to append before the link (like "__tel__:012 345 67" or "__mailto__:john@doe.com")
- attributes: optional
   - type: array
   - value: html attributes to add to the text

## Usage
```twig

<h4>Here are my personal informations</h4>

{# Default usage #}
<p>My name is : {{ contact.name|secureDisplay }}</p>

{# Custom label when JavaScript is not enabled #}
<p>You can find me at : {{ contact.address|secureDisplay('this address is protected') }}</p>

{# Transform phone number into clicable link #}
{# Can be 'tel', 'mailto', whatever you want #}
<p>My phone number is : {{ contact.phoneNumber|secureDisplay(null, 'tel') }}</p>

{# Custom html attributes #}
<p>My favorite color is : {{ contact.color|secureDisplay(null, null, { 'style': 'color: red' }) }}</p>
```

Of course, you can mix any of these tree parameters as you want.
