from django.db import models
from uuid import uuid4
from django.conf import settings
from .signals import CHANGE_TODO_STATUS, ASSIGN_TASK_TO_USER

TODO_STATUS = [
    ('TODO', "Todo"),
    ('DOING', "Doing"),
    ('DONE', "Done"),
]


class Todo(models.Model):
    id = models.UUIDField(default=uuid4, primary_key=True,
                          editable=False, verbose_name="ID")
    title = models.CharField(max_length=255, db_index=True)
    body = models.TextField(null=True, blank=True)
    status = models.CharField(
        default='TODO', max_length=5, choices=TODO_STATUS)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    assignees = models.ManyToManyField(
        settings.AUTH_USER_MODEL, related_name="todos")

    def __str__(self):
        return self.title

    def todo(self):
        CHANGE_TODO_STATUS.send(sender=self, todo_pk=self.pk, status='TODO')

    def doing(self):
        CHANGE_TODO_STATUS.send(sender=self, todo_pk=self.pk, status='DOING')

    def done(self):
        CHANGE_TODO_STATUS.send(sender=self, todo_pk=self.pk, status='DONE')

    def assign(self, user):
        ASSIGN_TASK_TO_USER.send(sender=self, todo_pk=self.pk, user=user)
