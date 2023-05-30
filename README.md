## Pet application "Link Shortener"
### Deployment and local run:

```
cp .env.example -> .env
```

#### In .env:
1) Specify your ports to the database and to the apache server.
2) Specify your telegram bot token and your chat ID for notification.

```
git config core.filemode false
```

```
docker-compose up --build
```

On your computer (not in docker!)

```
sudo chmod -R 777 *
```
