# Phoxx MVC

Phoxx is an attempt at creating a modular, lightweight, HMVC framework, based on a strong core.

## Features:

- Request and response architecture
- HVMC routing
- Modular structure
- Doctrine ORM
- Extensive cache support (Memcached, Apcu, Redis, File, Array)
- Multiple renderers (Twig, Smarty, PHP)
- Easily extensible

## Notes to self:

- Stuff breaks if the `PATH_*` variables are empty, with `.` being minimum. These paths should always be absolute, except for in tests.
- Maybe Session and Cache should use "storeValue" as opposed to "setValue"?
- Check exceptions for consistency in paths.
