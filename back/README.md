## Back
<hr>

### The algorithm for running:

1. Duplicate «.env.example» and rename to «.env»
```
cp .env.example .env
```

2. In «.env»<br>
2.1. Specify your ports to the database and to the apache server.<br>
2.2. Specify your telegram bot token and your chat ID for notification.

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

### Ready to start
