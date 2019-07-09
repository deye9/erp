# ERP

SAAS based ERP

## Start up

1. Database used is PostgresSQL
2. Uses CircleCI as the default CI platform
3. Application is available on either https://localhost or https://saas-erp.local [https redirection automatically takes place.]
4. Command to start up docker without cache `docker-compose down && docker-compose build --no-cache && docker-compose up -d && docker logs webserver`
5. Command to start up docker with cache `docker-compose down && docker-compose build && docker-compose up -d && docker logs webserver`
