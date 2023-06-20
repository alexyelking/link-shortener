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

1. Duplicate «.env.example» and rename to «.env» **in root folder**

```
cp .env.example .env
```

In «.env» specify all the necessary information or leave the existing one

2. Duplicate «.env.example» and rename to «.env» **in «app» folder**

In «.env» Specify all the necessary information

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
