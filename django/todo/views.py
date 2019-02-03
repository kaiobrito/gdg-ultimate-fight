from rest_framework.viewsets import ModelViewSet
from rest_framework.serializers import Serializer
from rest_framework.response import Response
from rest_framework.decorators import action
from .serializers import TodoSerializer


class TodoViewSet(ModelViewSet):
    serializer_class = TodoSerializer

    def get_queryset(self):
        return self.request.user.todos.all()

    @action(detail=True, methods=['post'], name='Mark it as todo', serializer_class=Serializer())
    def todo(self, request, pk):
        todo = self.get_queryset().get(pk=pk)
        todo.todo()
        return Response(status=204)

    @action(detail=True, methods=['post'], name='Mark it as doing', serializer_class=Serializer())
    def doing(self, request, pk):
        todo = self.get_queryset().get(pk=pk)
        todo.doing()
        return Response(status=204)

    @action(detail=True, methods=['post'], name='Mark todo as done', serializer_class=Serializer())
    def done(self, request, pk):
        todo = self.get_queryset().get(pk=pk)
        todo.done()
        return Response(status=204)
