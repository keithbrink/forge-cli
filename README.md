![forge-cli](https://cloud.githubusercontent.com/assets/11269635/24330714/fdfddfaa-1224-11e7-8f84-f1b4efa7a8b7.jpg)

# Forge CLI

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-codeclimate]][link-codeclimate]
[![Code Quality][ico-quality]][link-quality]
[![StyleCI][ico-styleci]][link-styleci]

Interact with your [Laravel Forge](https://forge.laravel.com) servers and sites via the command line with this package. Create and list
servers, add sites, and install repositories all without leaving the comfort of your command line. An overview of all available commands
can be found [here](#usage).

## Installation
Via [composer](http://getcomposer.org):

```bash
$ composer global require sven/forge-cli
```

## Setup
Ensure Composer's global `bin` directory is included in your path. This directory is located at `~/.composer/vendor/bin` on macOS / Linux, and at
`%APPDATA%/Composer/vendor/bin` on Windows.

Before using the commands, you have to provide an API token. To generate a new token, visit [this page](https://forge.laravel.com/user/profile#/api),
give the token a name (like `ForgeCLI`) and click "Create new token". 

Then, execute the following command on the command line:

```bash
$ forge authorize
```

When prompted for it, paste in your API key.

If the API key on your Forge account changed, you'll need to run the same command again. The configuration file will be saved to your home
directory (`~/forge.json` on macOS / Linux, `%USERPROFILE%/forge.json` on Windows).

## Usage
A list of commands with their explanation can be found below. You can also find a list of commands and their arguments by installing the package
and running `forge list` or `forge help {command}`.

---

### Servers

#### list:servers
Show all servers associated with your account.

```bash
$ forge list:servers

+----------------+--------+----------------+-------------+-------+
| Name           | Id     | IP Address     | Region      | Ready |
+----------------+--------+----------------+-------------+-------+
| sparkling-reef | 124833 | 95.85.60.157   | Amsterdam 2 | Yes   |
+----------------+--------+----------------+-------------+-------+
```

#### show:server
Show information about one of your servers.

```bash
$ forge show:server {serverId}

Name:        sparkling-reef
IP Address:  95.85.60.157
Size:        512MB
Region:      Amsterdam 2
PHP version: php71
Created:     2017-03-13 20:59:16
```
    
#### create:server
Create a new server.

```bash
$ forge create:server
    --provider=ocean2
    --credential={credentialId}
    --region=ams2
    --ip=127.0.0.1
    --private-ip=192.168.1.1
    --php=php71
    --database=some_database
    --install-maria
    --load-balancer
    --network={otherServerId}
    --network={anotherServerId}
```

#### update:server
Update the metadata on one of your servers. This will only update the data in Forge, it won't make any actual
changes to your server.

```bash
$ forge update:server {serverId} 
    --name=sluggish-cheetah
    --size=1GB
    --ip=127.0.0.1
    --private-ip=192.168.1.1
    --max-upload-size=256
    --network={otherServerId}
    --network={anotherServerId}    
```

#### reboot:server
Reboot one of your servers. You will need to confirm you action.

```bash
$ forge reboot:server {serverId}
```

#### delete:server
Delete an existing server. You will need to confirm your action.

```bash
$ forge delete:server {serverId}
```

---

### Sites

#### list:sites
Show all sites installed on a server.

```bash
$ forge list:sites {serverId}

+--------+-----------------+------+-----------------------------+--------+
| Id     | Name            | Type | Repository                  | Branch |
+--------+-----------------+------+-----------------------------+--------+
| 303243 | default         | php  | -                           | -      |
| 303246 | svenluijten.com | html | svenluijten/svenluijten.com | master |
| 303247 | pkgst.co        | php  | svenluijten/slack-packagist | master |
+--------+-----------------+------+-----------------------------+--------+
```

#### show:site
Show information about a site on a specified server.

```bash
$ forge show:site {serverId} {siteId}

Name:            svenluijten.com
Repository info: svenluijten/svenluijten.com @ master
Directory:       /build_production
Quick deploy:    Off
Status:          installed
Project type:    html
Created:         2017-03-13 21:14:19
```

#### create:site
Create a new site on one of your servers.

```bash
$ forge create:site {serverId} 
    --domain=example.com
    --type=php
    --directory=/public
```

#### update:site
Update a site on a specified server.

```bash
$ forge update:site {serverId} {siteId}
    --directory=/html
```

#### delete:site
Delete a site. You will need to confirm your action.

```bash
$ forge delete:site {serverId} {siteId}
```

---

### Services

#### reboot:service
Reboot a service on the given server. Supported services are `nginx`, `mysql`, and `postgres`.

```bash
$ forge reboot:service {serverId} {service}
```

#### stop:service
Stop a service on the given server. Supported services are `nginx`, `mysql`, and `postgres`.

```bash
$ forge stop:service {serverId} {service}
```

#### install:service
Install a service on the given server. Supported services are `blackfire` and `papertrail`. The `--host` option
is only required when installing Papertrail, `--server-id` and `--server-token` are only required when installing
Blackfire.

```bash
$ forge install:service {serverId} {service}
    --host=192.168.1.1
    --server-id=12345
    --server-token=YOUR_SERVER_TOKEN
```

#### uninstall:service
Uninstall a service from the given server. Supported services are `blackfire` and `papertrail`.

```bash
$ forge uninstall:service {serverId} {service}
```

---

### Daemons

#### list:daemons
List all active daemons on the given server.

```bash
$ forge list:daemons {serverId}

+-------+------------+---------------------------------+---------------------+
| Id    | Status     | Command                         | Created             |
+-------+------------+---------------------------------+---------------------+
| 12345 | installing | echo 'hello world' >> /dev/null | 2017-03-13 21:14:19 |
+-------+------------+---------------------------------+---------------------+
```

#### show:daemon
Show information about the given daemon.

```bash
$ forge show:daemon {serverId} {daemonId}

Status:  installing
Command: echo 'hello world' >> /dev/null
Created: 2017-03-21 18:26:33
```

#### create:daemon
Create a new daemon to run on the given server. If no user is supplied, it defaults to `forge`.

```bash
$ forge create:daemon {serverId}
    --command="command to run"
    --user=root
```

#### reboot:daemon
Reboot the given daemon. You will need to confirm your action.

```bash
$ forge reboot:daemon {serverId} {daemonId}
```

#### delete:daemon
Delete the given daemon from the given server. You will need to confirm your action.

```bash
$ forge delete:daemon {serverId} {daemonId}
```

---

### Firewall Rules

#### create:rule
Create a new firewall rule.

```bash
$ forge create:rule {serverId}
    --name="firewall rule"
    --port=88
```

#### all:rules
Show all firewall rules.

```bash
$ forge all:rules {serverId}
```

#### show:rule
Show information about one of your firewall rules.

```bash
$ forge show:rule {serverId} {ruleId}
```

#### delete:rule
Delete a given firewall rule from one of your servers. You will need to confirm your action.

```bash
$ forge delete:rule {serverId} {ruleId}
```

---

### Scheduled jobs

#### create:job
Create a new scheduled job.

```bash
$ forge create:job {serverId}
    --command="echo 'hello world' > /dev/null"
    --frequency="hourly"
```

#### all:jobs
Show all scheduled jobs.

```bash
$ forge all:jobs {serverId}
```

#### show:job
Show information about one of your scheduled jobs.

```bash
$ forge show:job {serverId} {jobId}
```

#### delete:job
Delete a given scheduled job from one of your servers. You will need to confirm your action.

```bash
$ forge delete:job {serverId} {jobId}
```

---

### Databases

#### create:database
Create a new database. The flags `--user` and `--password` must either both be present or both
be absent.

```bash
$ forge create:database {serverId}
    --user="sven"
    --password="My_P45sw0rD"
```

#### all:databases
Show all databases on a server.

```bash
$ forge all:databases {serverId}
```

#### show:database
Show information about one of your databases.

```bash
$ forge show:database {serverId} {databaseId}
```

#### delete:database
Delete a given database from one of your servers. You will need to confirm your action.

```bash
$ forge delete:database {serverId} {databaseId}
```

---

### SSL certificates
SSL certificates documentation...

---

### SSH keys
SSH keys documentation...

---

### Workers
Workers documentation...

---

### Deployment

#### deploy:site
Deploy the given site.

```bash
$ forge deploy:site {serverId} {siteId}
```

#### site:enable-quickdeploy
Enable quick deployment for the given site.

```bash
$ forge site:enable-quickdeploy {serverId} {siteId}
```

#### site:disable-quickdeploy
Disable quick deployment for the given site.

```bash
$ forge site:disable-quickdeploy {serverId} {siteId}
```

#### site:get-deploy-script
Get the deployment script of the given site.

```bash
$ forge site:get-deploy-script {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge site:get-deploy-script {serverId} {siteId} > file.txt
```

#### site:update-deploy-script
Update the deployment script of the given site.

```bash
$ forge site:update-deploy-script {serverId} {siteId}
    --file=file.txt
```

If you do not supply the `--file` option, the command will look in `STDIN` for any input:

```bash
$ forge site:update-deploy-script {serverId} {siteId} < file.txt
```

#### site:deploy-log
Show the deployment log.

```bash
$ forge site:deploy-log {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge site:deploy-log {serverId} {siteId} > file.log
```

#### site:reset-deployment-status
Reset the status of the deployment.

```bash
$ forge site:reset-deployment-status
```

---

### Configuration
Configuration documentation...

---

### Projects
Projects documentation...

---

### Recipes
Recipes documentation...

---

### Credentials
Show all credentials associated with your account.

```bash
$ forge credentials

+-------+----------+--------+
| Id    | Name     | Type   |
+-------+----------+--------+
| 15071 | Personal | ocean2 |
+-------+----------+--------+
```

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/forge-cli` is licensed under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/forge-cli.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/forge-cli.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/svenluijten/forge-cli.svg?style=flat-square
[ico-codeclimate]: https://img.shields.io/codeclimate/github/svenluijten/forge-cli.svg?style=flat-square
[ico-quality]: https://img.shields.io/scrutinizer/g/svenluijten/forge-cli.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/85804300/shield

[link-packagist]: https://packagist.org/packages/sven/forge-cli
[link-downloads]: https://packagist.org/packages/sven/forge-cli
[link-travis]: https://travis-ci.org/svenluijten/forge-cli
[link-codeclimate]: https://codeclimate.com/github/svenluijten/forge-cli
[link-quality]: https://scrutinizer-ci.com/g/svenluijten/forge-cli/?branch=master
[link-styleci]: https://styleci.io/repos/85804300
