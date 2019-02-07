# GDG Ultimate Fight

## Setup

### Using docker

```

# Run this on the very first time
# docker volume create --name=db_volume

docker-compose up
```

### Using Pipenv

If you don't have pipenv installed, [follow this instructions](https://pipenv.readthedocs.io/en/latest/#install-pipenv-today).

```
pipenv sync
pipenv run ./manage.py migrate
pipenv run ./manage.py runserver
```

# DO NOT RUN THIS CODE IN PRODUCTION
