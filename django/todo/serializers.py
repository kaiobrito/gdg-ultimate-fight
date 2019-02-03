from rest_framework import serializers
from django.contrib.auth.models import User
from .models import Todo


class UserSerializer(serializers.Serializer):
    id = serializers.ReadOnlyField()
    username = serializers.ReadOnlyField()
    email = serializers.ReadOnlyField()


class TodoSerializer(serializers.ModelSerializer):
    assignees = UserSerializer(many=True, read_only=True)

    class Meta:
        model = Todo
        fields = '__all__'


class AssignSerializer(serializers.Serializer):
    user = serializers.PrimaryKeyRelatedField(
        queryset=User.objects.filter(is_active=True))
