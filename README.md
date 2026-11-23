# 🚀 Caso Práctico: CI/CD con Nginx, PHP y MariaDB en GitHub Actions

> **Módulo:** Despliegue de Aplicaciones Web (2º DAW)  
> **Tecnologías:** Nginx, PHP 8.2-FPM, MariaDB 11.4, Docker, GitHub Actions

---

## 📋 Estructura del Proyecto

```text
caso-practico-nginx-php-mariadb/
├── .github/
│   └── workflows/
│       └── ci-cd.yml       # Workflow CI/CD con Service Container MariaDB y Healthcheck
├── src/
│   ├── db.php              # Módulo de conexión PDO (TCP/IP)
│   └── index.php           # Interfaz web y prueba de versión MariaDB
├── nginx/
│   └── default.conf        # Configuración de servidor web Nginx (escuchando en minúsculas)
├── compose.yaml            # Orquestación multicontenedor local
├── Dockerfile              # Imagen empaquetada (PHP-FPM + Nginx)
├── .env                    # Configuración de variables de entorno locales
└── README.md               # Documentación
```

---

## 🚀 Despliegue Local con Docker Compose

```bash
docker compose up -d --build
```
Accede en el navegador a `http://localhost:8080`.

---

## 🛡️ Secretos en GitHub Actions

En tu repositorio (**Settings -> Secrets and variables -> Actions**), configura:
- `MARIADB_ROOT_PASSWORD`: `docker123`
- `MARIADB_DATABASE`: `empresa`
- `MARIADB_USER`: `alumno_daw`
- `MARIADB_PASSWORD`: `password_segura_123`
