# Tyk webhook event handler

This is a Flask-based microservice listening to events sent from tyk gateways. It's running on port 5000. When something happened at the tyk gateways' side, a POST request is sent to this service. Then, this service will send e-mails to the addresses configured in the `contacts.json`.

To start this service, install `uwsgi` first. Then run the following command under this directory:

```
$ uwsgi --ini ors_api_alerts-uwsgi.ini
```

To stop the service, run:

```
uwsgi --stop /tmp/orsalerts.pid
```
