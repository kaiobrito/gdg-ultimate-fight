from rest_framework.viewsets import ModelViewSet
from .serializers import TodoSerializer


class TodoViewSet(ModelViewSet):
    serializer_class = TodoSerializer

    def get_queryset(self):
        return self.request.user.todos.all()
