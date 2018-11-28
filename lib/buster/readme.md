# Buster

> Creates new version numbers based on the current time measured in the number of seconds since the Unix Epoch.

Everytime you execute the `NodeJS` or `PHP` script it's going to update the version number. If the `.deploy.json` file already
exist, is going to update the file if does not exist it's going to create a new one, so you need to make
sure when you are running the script that you have writting permissions ([unix permissions](https://en.wikipedia.org/wiki/File_system_permissions#Permissions)) on the directoy where the script is executed.

## PHP Version

### Installation

```bash
composer require wearenolte/buster
```

### Usage

```bash
# Installed via composer
php ./vendor/bin/version

# Directly on the package
php ./bin/version
```

## Node Version

### Installation 

```bash
npm install --save-dev @wearenolte/buster
```

### Usage

```bash
node bin/version.js 
```

Any of the previous examples it's going to create a new JSON file located at `./deploy.json`.

- if something fails it's goign to return a code of `1` and an empty JSON object is going to be created.
- if everything was correct it's going to return `0` a JSON object with a `version` is going to be
  created.
