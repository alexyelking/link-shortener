### The algorithm for running:

Docker and Docker-compose are required to run

#### In the root folder

1. Duplicate «.env.example» and rename to «.env»

```
cp .env.example .env
```

2. Specify a free port to follow the link, or leave the one that has already been installed

3. Git config core file mode must be false

```
git config core.filemode false
```

4. Launch Docker-compose

```
docker-compose up --build
```

5. Wait for npm to finish working (Until the contents of the «node_modules» folder appear completely)

6. Grant rights for convenience in the root of the project

```
sudo chmod -R 777 *
```

7. Go through localhost:**PORT** (Default PORT is 8080)

<hr>

### Ready to start
