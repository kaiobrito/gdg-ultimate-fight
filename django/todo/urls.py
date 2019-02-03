from .views import TodoViewSet
from rest_framework.routers import DefaultRouter

router = DefaultRouter(trailing_slash=False)
router.register(r'todos', TodoViewSet, basename='todo')

urlpatterns = router.urls
