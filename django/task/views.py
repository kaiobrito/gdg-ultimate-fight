from django.contrib.auth.models import User
from rest_framework.viewsets import ModelViewSet
from rest_framework.serializers import Serializer
from rest_framework.response import Response
from rest_framework.decorators import action
from .serializers import TaskSerializer, AssignSerializer


class TaskViewSet(ModelViewSet):
    serializer_class = TaskSerializer
    filter_fields = ('status', )
    search_fields = ('title', 'body', 'assignees__username',
                     'assignees__email')

    def get_queryset(self):
        return self.request.user.tasks.all()

    def perform_create(self, serializer):
        task = serializer.save()
        task.assign(self.request.user)

    @action(detail=True, methods=['post'], name='Mark task as todo', serializer_class=Serializer)
    def task(self, request, pk):
        task = self.get_queryset().get(pk=pk)
        task.task()
        return Response(status=204)

    @action(detail=True, methods=['post'], name='Mark task as doing', serializer_class=Serializer)
    def doing(self, request, pk):
        task = self.get_queryset().get(pk=pk)
        task.doing()
        return Response(status=204)

    @action(detail=True, methods=['post'], name='Mark task as done', serializer_class=Serializer)
    def done(self, request, pk):
        task = self.get_queryset().get(pk=pk)
        task.done()
        return Response(status=204)

    @action(detail=True, methods=['post'], serializer_class=AssignSerializer)
    def assign(self, request, pk):
        task = self.get_queryset().get(pk=pk)
        serializer = self.get_serializer(data=request.data)
        serializer.is_valid(raise_exception=True)
        user = User.objects.get(pk=serializer.data.get('user'))
        task.assign(user)
        return Response(status=201)
