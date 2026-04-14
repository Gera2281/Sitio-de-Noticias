# Documentación del Proyecto: Sitio de Noticias

## 1. Objetivo General
Desarrollar una plataforma web de gestión de noticias que permita la publicación de contenido categorizado mediante un flujo de trabajo controlado por roles (Editor, Revisor y Espectador), garantizando la integridad y calidad de la información publicada.

## 2. Alcance
El alcance del proyecto abarca las siguientes funcionalidades y componentes:

*   **Gestión de Usuarios y Roles:** Implementación de un sistema de autenticación con tres niveles de acceso:
    *   **Editor:** Responsable de la creación de noticias, incluyendo título, descripción, contenido e imágenes.
    *   **Revisor:** Encargado de supervisar las noticias pendientes, con la facultad de aprobarlas para su publicación o rechazarlas.
    *   **Espectador (Invitado/Autenticado):** Acceso a la lectura de noticias que han sido previamente aprobadas.
*   **Categorización Estratégica:** El contenido se organiza en cinco áreas clave: Deportes, Tecnología, Internacionales, Clima y Locales.
*   **Sistema de Estados (Workflow):** Implementación de una lógica de estados para las noticias (`pending`, `approved`, `rejected`) que controla su visibilidad en el sitio.
*   **Gestión de Multimedia:** Capacidad para adjuntar una imagen representativa a cada noticia, almacenada de forma local en el servidor.
*   **Interfaz de Usuario (UI/UX):** Desarrollo de una interfaz intuitiva y responsiva, permitiendo la navegación fluida entre categorías y una lectura cómoda de los detalles de cada noticia.
*   **Panel de Administración por Rol:** Vistas personalizadas para Editores (formularios de creación) y Revisores (listas de aprobación).

## 3. Limitaciones
El proyecto presenta las siguientes restricciones en su etapa actual:

*   **Categorías Estáticas:** No se permite la creación o modificación de categorías desde el panel de usuario; estas están definidas a nivel de base de datos y código.
*   **Ausencia de Interactividad Social:** No se incluyen sistemas de comentarios, foros de discusión o botones para compartir en redes sociales.
*   **Edición Limitada:** En la versión actual, el flujo no contempla la edición de una noticia una vez enviada a revisión.
*   **Contenido Local:** El sistema depende exclusivamente de la entrada manual de datos por parte de los editores, sin integración con servicios de noticias externos.
*   **Búsqueda y Filtrado:** No existe una funcionalidad de búsqueda global por texto o filtrado avanzado por fecha o etiquetas.
*   **Notificaciones:** No se cuenta con un sistema de notificaciones por correo electrónico o notificaciones push para informar sobre cambios de estado en las noticias.
