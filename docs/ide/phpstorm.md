# PhpStorm

## 1. Use PhpCsFixer on each save
You need to add a "File Watcher" for execute PhpCsFixer on each save `Tools > File Watcher` \
Add an new File Watcher with this configuration :
* File Type : Php
* Scope : 
  * New Scope and add Recursively Dirs `src` and `tests`
* Program : `$ProjectFileDir$/docker-phpfixer`
* Arguments : `fix $FileDirRelativeToProjectRoot$/$FileName$`
* Uncheck this `Auto-save edited files to trigger the watcher`

## 2. Disable many inspections : 
- `PHP > Quality Tools > PHP CS Fixer validation` 
- `PHP > Quality Tools > PHPStan validation` 

## Add Cli Interpeter since Docker
Go to `PHP > Cli Interpreter` \
Add `New from Docker, ....` \
\
Select `Docker Compose` : 
- Server: `Docker`
- Configuration files: `./docker-composer.yml`
- Service: `mact-php`

Choose for `Lifecircle` : `Connect to a existing container` \
Check Configuration PHP
