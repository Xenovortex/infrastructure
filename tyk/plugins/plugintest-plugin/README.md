# Python plugin for ORS directions API

## Plugin overview

This project provides a [Tyk](https://tyk.io) plugin for directions API.

It implements a middleware for some customized limitations calculated with some querystring parameters values, using a **Pre** hook (see [How do rich plugins work?](https://tyk.io/tyk-documentation/customise-tyk/plugins/rich-plugins/rich-plugins-work/#how-do-rich-plugins-work)). A single Python script contains the code for it, see [directions_guard.py](directions_guard.py).

## Requirements

See [Python Rich Plugins](https://tyk.io).

## Instructions

After checking the requirements, download all the files in this directory into
a new local plugin directory.

Enter the plugin directory:

```
$ cd ors-gateway-plugin
```

## Building a bundle

Python plugins are delivered as plugin bundles. The manifest file (`manifest.json`) contains the custom middleware definition. The manifest references the files that should be part of the bundle.

```
$ tyk-cli bundle build
```

You may check the [tyk-cli documentation](https://github.com/TykTechnologies/tyk-cli) for additional options.

## Additional documentation

- [An overview of Python support in Tyk](https://tyk.io/extend-tyk/with-python/)
