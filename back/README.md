### Implemented endpoints

<hr>

|     Path      | Method | Parameters |     Explanation     |
|:-------------:|:------:|:----------:|:-------------------:|
|    /links     |  GET   |     -      | Links index (list)  |
| /link/create  |  POST  |   source   |  Short link create  |
| /{short_link} |  GET   |     -      | Go through the link |

<hr>

### The algorithm for running:

Docker and Docker-compose are required to run

1. Duplicate «.env.example» and rename to «.env»

```
cp .env.example .env
```

2. In «.env»

   2.1. Specify a free port for «MYSQL», «APACHE2» and «RABBITMQ_UI», or leave the one that has already been installed

   2.2. Specify your telegram bot token and your chat ID for notification.

   2.3. Specify the limits of link abbreviations: "REDIS_LIMIT_COUNT" and "REDIS_LIMIT_TIME", where the first is the
   number of abbreviations, and the second is how long it takes to make a certain number of abbreviations. The time
   limit is specified in seconds

3. Git config core file mode must be false

```
git config core.filemode false
```

4. Launch Docker-compose

```
docker-compose up --build
```

5. Wait for composer to finish working (the «autoload» file will appear in the «vendor» folder)

6. Grant rights for convenience in the root of the project

```
sudo chmod -R 777 *
```

<hr>

### Ready to start
