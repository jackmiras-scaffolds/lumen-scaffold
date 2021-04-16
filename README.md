# Preface

This project is Lumen REST API scaffold built to serve as a quick starting point
for any Lumen REST API. This scaffold runs over a Docker container. Interactions
with these containers are interface by a shell script called vessel.

## Docker

All content related to how the Docker image was build can be found down below.
Be adivided that inside the .docker/, you will find Dockerfile and docker-compose.yml
implementations using Alpine, Debian Slim and Ubuntu.

- .docker/
- Dockerfile
- docker-composer.yml
- .dockerignore



## Vessel
Vessel was written to expose short versions of commands that are used too often
when debugging, developing code, and executing CI actions such as running
linters, fix-linters, and tests.

For example, without vessel the process of executing a Lumen command inside
the container to create a model would be  something like
`docker-compose exec -T app sh -c "cd /var/www/html && php artisan make:migration Test"`
with vessel the same result can be achieved by executing `./vessel artisan make:migration Test`.

Another good example of vessel usage would be the up command. With `./vessel up`
the docker-compose.yml file will be built but also the **xdebug.ini** file will
be created with the right configs and your current IP address to make the usage
of Xdebug possible. If you choose to start the container by running
`docker-compose up` bear in mind that Xdebug will not work.

### Available vessel commands

| Command                        | Description                                          |
| ------------------------------ |------------------------------------------------------|
| ./vessel up                    | Initialize docker-compose stack                      |
| ./vessel down                  | Stop docker-compose stack                            |
| ./vessel bash                  | Access bash of the app container                     |
| ./vessel clean-all             | Prune all possible containers, volumes, and networks |
| ./vessel artisan <ANY_COMMAND> | Run any Lumen artisan command                        |
| ./vessel tinker                | Open a REPL for the Lumen framework                  |
| ./vessel composer              | Run any composer command                             |
| ./vessel pest                  | Run test swite using Pest framework                  |
| ./vessel tests                 | Run test swite with code coverage                    |
| ./vessel linters               | Run linters                                          |
| ./vessel fix-linters           | Run linter fixer                                     |
| ./vessel update-dependencies   | Update composer dependencies                         |

___

## Linters

The project has [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer),
 [PHP Mess Detector](https://phpmd.org/download/index.html) configured as linters, the files
containing the rules used by them are phpmd.xml and phpcs.xml. As for fixers we have
[PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer#installation)
 configured, and its rules can be found at .php_cs.



## Static Analysis

The project has [PHPCPD](https://github.com/sebastianbergmann/phpcpd),
 [PSALM](https://psalm.dev/docs/running_psalm/installation), and
 [Larastan](https://github.com/nunomaduro/larastan) configured as static analyzers.
 Larastan has also a file phpstan.neon containing the rules used, while the other two don't have any configuration file.



## Hooks

The project has [composer-git-hooks](https://github.com/BrainMaestro/composer-git-hooks) as Git hook manager.
At [composer.json](https://github.com/jackmiras-scaffolds/laravel-scaffold/blob/main/composer.json#L48-L60)
you will finde pre-push, pre-commit and post-merge git events configured.



## Tests

This scaffold supports [PHPUnit](https://phpunit.de/getting-started/phpunit-9.html)
and [Pest](https://pestphp.com/docs/installation), around the project exists
a few tests related to basic helpers and structures created to speed the
development process of API's and those tests are written to be Pest compliant.



## Text editors

This project was mainly coded with Neovim, but there is also a **.vscode** and **.idea** directories
that holds configurations of VSCode|PHPStorm + Docker + Xdebug, and the configurations of linters.
In order to make everything work in VSCode or PHPStorm you may need to install the following plugins
**PHP Debug (VSCode only)**, **PHP Mess Detector**, **phpcs**, **php cs fixer**.

This has been tested locally and there is no guarantee that it will work on other
peoples machine. In any case this may be a head start if you wanna have this aspect
of the project working in your machine.
