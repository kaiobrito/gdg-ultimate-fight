from .views import TaskViewSet
from rest_framework.routers import DefaultRouter

router = DefaultRouter(trailing_slash=False)
router.register(r'tasks', TaskViewSet, basename='todo')

urlpatterns = router.urls
