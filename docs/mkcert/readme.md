# mkcert

mkcert is a simple tool for making locally-trusted development certificates. It requires no configuration.

Binary is updated for : 
- Decrease the certificate expiry date (13 months)
- Add firefox ubuntu snap support

## Install local CA for traefik

```bash
$ cd ./scripts

$ ./scripts/mkcert -install

The local CA is already installed in the system trust store! 👍
The local CA is already installed in the Firefox and/or Chrome/Chromium trust store! 👍
```

## Generate wildcard certificate for traefik
```bash
$ ./mkcert -cert-file "../docker/traefik/config/certs/cert.crt" -key-file "../docker/traefik/config/certs/cert.key" "*.mact.localhost"

Created a new certificate valid for the following names 📜
 - "*.mact.localhost"

Reminder: X.509 wildcards only go one level deep, so this won't match a.b.mact.localhost ℹ️

The certificate is at "../docker/traefik/config/certs/cert.crt" and the key at "../docker/traefik/config/certs/cert.key" ✅

It will expire on 19 July 2023 🗓
``̀`
