## Backend test SunMedia

Solution to the technical test.

## How to check the tests

Start docker environment
 
```shell
docker-compoe up -d --build
```

Then enter in the container and launch the tests:
```shell
docker exec -it php-server php vendor/bin/phpunit
```

Thanks