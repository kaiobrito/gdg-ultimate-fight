# GDG Ultimate Fight

## Setup

### Using docker

```
docker-compose up
docker-compose
```

### Using Pipenv

If you don't have pipenv installed, [follow this instructions](https://pipenv.readthedocs.io/en/latest/#install-pipenv-today).

```
pipenv sync
pipenv run ./manage.py migrate
pipenv run ./manage.py runserver
```
