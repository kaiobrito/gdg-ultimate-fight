FROM python:3.7-slim
ENV PYTHONUNBUFFERED 1
ENV PROJECT_ROOT /code

WORKDIR /code
ADD . /code/
RUN pip install -r requirements.txt
RUN python manage.py collectstatic --no-input
