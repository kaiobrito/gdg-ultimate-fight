from django.apps import AppConfig
from .signals import connect


class TaskConfig(AppConfig):
    name = 'task'

    def ready(self):
        connect()
