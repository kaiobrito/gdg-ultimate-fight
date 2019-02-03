from django.apps import AppConfig
from .signals import connect


class TodoConfig(AppConfig):
    name = 'todo'

    def ready(self):
        connect()
