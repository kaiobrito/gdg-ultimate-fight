from django.core import signals

CHANGE_TODO_STATUS = signals.Signal(providing_args=['todo_pk', 'status'])


def connect():
    pass
