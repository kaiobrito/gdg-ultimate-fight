from django.core import signals
from django.core.mail import send_mail

CHANGE_TODO_STATUS = signals.Signal(providing_args=['todo_pk', 'status'])
ASSIGN_TASK_TO_USER = signals.Signal(providing_args=['todo_pk', 'user_pk'])


def assignUserToTask(todo_pk, user, **kwargs):
    from .models import Todo
    todo = Todo.objects.get(pk=todo_pk)
    todo.assignees.add(user)

    recipient_list = map(lambda user: user.email,
                         todo.assignees.filter(email__isnull=False))
    send_mail("New Task", "You were assigned to task {0}".format(
        todo.title), "from@example.com", recipient_list)


def onChangeTodoStatus(todo_pk, status, **kwargs):
    from .models import Todo
    todo = Todo.objects.get(pk=todo_pk)
    todo.status = status
    todo.save()

    recipient_list = map(lambda user: user.email,
                         todo.assignees.filter(email__isnull=False))

    send_mail("Status changed", "Status of todo {0} was changed to {1}".format(
        todo.title, status), "from@example.com", recipient_list)


def connect():
    CHANGE_TODO_STATUS.connect(onChangeTodoStatus)
    ASSIGN_TASK_TO_USER.connect(assignUserToTask)
