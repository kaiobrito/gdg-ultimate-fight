from django.db import models
from uuid import uuid5
from django.conf import settings

TODO_STATUS = [
    ('TODO', "todo"),
    ('DOING', "Doing"),
    ('DONE', "Done"),
]


class Todo(models.Model):
    id = models.UUIDField(default=uuid5, primary_key=True)
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
