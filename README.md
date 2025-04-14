# php-k8s-ci-cd-app
Automatización de Despliegues con GitHub Actions, Docker Compose y Kubernetes
Descripción del Proyecto
Este proyecto tiene como objetivo configurar un flujo de CI/CD para un proyecto PHP utilizando GitHub Actions, Docker Compose y Kubernetes (K8s). El despliegue es automatizado en un servidor remoto, permitiendo un flujo de trabajo eficiente para la integración y entrega continua.

Objetivo
Configurar un flujo de trabajo de CI/CD para un proyecto PHP en GitHub utilizando Kubernetes (K8s) y Docker, automatizando el despliegue en un servidor remoto.

Requisitos Previos
Cuenta en GitHub.

Servidor remoto con Docker y Kubernetes instalados.

GitHub Actions habilitado en el repositorio.

Autenticación configurada para acceso sin contraseña al servidor remoto.

Pasos del Ejercicio
1. Crear el Repositorio
Ve a GitHub.

Nombre sugerido: php-k8s-ci-cd-app.

Marca la opción "Initialize with a README".

Crea el repositorio.

2. Clonar el Repositorio
<pre>
git clone https://github.com/tu_usuario/php-k8s-ci-cd-app.git
cd php-k8s-ci-cd-app
</pre>
3. Estructura Básica del Proyecto
Crea las carpetas y archivos necesarios para la aplicación y configuración de CI/CD:
<pre>
mkdir -p public tests .github/workflows k8s
touch Dockerfile docker-compose.yml .dockerignore .gitignore
</pre>
La estructura del proyecto será la siguiente:
<pre>
php-k8s-ci-cd-app/
├── .github/workflows/deploy.yml
├── k8s/
│   ├── deployment.yaml
│   ├── service.yaml
│   ├── mysql-deployment.yaml
│   ├── mysql-service.yaml
│   └── ingress.yaml
├── public/
│   └── index.php
├── tests/
│   └── SimpleTest.php
├── Dockerfile
├── docker-compose.yml
├── .dockerignore
├── .gitignore
└── README.md
</pre>
4. Código de la Aplicación PHP
En el archivo public/index.php, agrega el siguiente código para conectarte a la base de datos y listar los registros de una tabla:
<pre>
<?php
$mysqli = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT id, nombre FROM personas");

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . "<br>";
}
$mysqli->close();
?>
</pre>
Automatización de Despliegues con GitHub Actions, Docker Compose y Kubernetes
Descripción del Proyecto
Este proyecto tiene como objetivo configurar un flujo de CI/CD para un proyecto PHP utilizando GitHub Actions, Docker Compose y Kubernetes (K8s). El despliegue es automatizado en un servidor remoto, permitiendo un flujo de trabajo eficiente para la integración y entrega continua.

Objetivo
Configurar un flujo de trabajo de CI/CD para un proyecto PHP en GitHub utilizando Kubernetes (K8s) y Docker, automatizando el despliegue en un servidor remoto.

Requisitos Previos
Cuenta en GitHub.

Servidor remoto con Docker y Kubernetes instalados.

GitHub Actions habilitado en el repositorio.

Autenticación configurada para acceso sin contraseña al servidor remoto.

Pasos del Ejercicio
1. Crear el Repositorio
Ve a GitHub.

Nombre sugerido: php-k8s-ci-cd-app.

Marca la opción "Initialize with a README".

Crea el repositorio.

2. Clonar el Repositorio
<pre>
git clone https://github.com/tu_usuario/php-k8s-ci-cd-app.git
cd php-k8s-ci-cd-app
</pre>
3. Estructura Básica del Proyecto
Crea las carpetas y archivos necesarios para la aplicación y configuración de CI/CD:
<pre>
mkdir -p public tests .github/workflows k8s
touch Dockerfile docker-compose.yml .dockerignore .gitignore
</pre>
La estructura del proyecto será la siguiente:
<pre>
php-k8s-ci-cd-app/
├── .github/workflows/deploy.yml
├── k8s/
│   ├── deployment.yaml
│   ├── service.yaml
│   ├── mysql-deployment.yaml
│   ├── mysql-service.yaml
│   └── ingress.yaml
├── public/
│   └── index.php
├── tests/
│   └── SimpleTest.php
├── Dockerfile
├── docker-compose.yml
├── .dockerignore
├── .gitignore
└── README.md
</pre>
4. Código de la Aplicación PHP
En el archivo public/index.php, agrega el siguiente código para conectarte a la base de datos y listar los registros de una tabla:
<pre>
<?php
$mysqli = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT id, nombre FROM personas");

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . "<br>";
}
$mysqli->close();
?>
</pre>
5. Crear el Dockerfile
En el archivo Dockerfile, agrega el siguiente contenido para crear la imagen de Docker:
<pre>
FROM php:8.2-apache
COPY public/ /var/www/html/
EXPOSE 80
</pre>
6. Construir y Probar la Imagen Localmente (Opcional)
Construir la imagen Docker:
<pre>
docker build -t tu-usuario/php-k8s-app:latest .
docker push tu-usuario/php-k8s-app:latest
</pre>
Probar la imagen localmente:
<pre>
docker run -p 8080:80 -e DB_HOST=localhost -e DB_USER=root -e DB_PASS= -e DB_NAME=demo tu-usuario/php-k8s-app:latest
Visita http://localhost:8080 para verificar que la aplicación funcione correctamente.
</pre>
7. Crear un Registro en Docker Hub
Regístrate en Docker Hub.

Crea un nuevo repositorio en Docker Hub para almacenar la imagen de Docker.

8. Configurar GitHub Actions para CI/CD
Crea el archivo de flujo de trabajo en .github/workflows/deploy.yml con el siguiente contenido:
<pre>
name: Build and Deploy to Docker Hub
on:
  push:
    branches: [main]
jobs:
  build-and-push:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout repository
      uses: actions/checkout@v3

    - name: Log in to Docker Hub
      uses: docker/login-action@v1
      with:
        username: ${{ secrets.DOCKERHUB_USERNAME }}
        password: ${{ secrets.DOCKERHUB_TOKEN }}

    - name: Build and push Docker image
      uses: docker/build-push-action@v2
      with:
        context: .
        push: true
        tags: tu-usuario/php-k8s-app:latest
</pre>
9. Crear el Deployment de Kubernetes
Crea los archivos de configuración de Kubernetes en la carpeta k8s/:

deployment.yaml: Define el despliegue de la aplicación PHP y MySQL.

service.yaml: Configura el servicio de la aplicación PHP.

mysql-deployment.yaml: Despliega el contenedor de MySQL.

mysql-service.yaml: Define el servicio para MySQL.

ingress.yaml: Configura el ingreso para la aplicación PHP.

Aplica los manifiestos de Kubernetes con:

kubectl apply -f k8s/deployment.yaml
10. Pasos Siguientes Sugeridos
Modificar tu archivo hosts local para acceder a la aplicación mediante http://php.local.

Levantar el Ingress en Minikube (si no lo tienes activado).
<pre>
minikube addons enable ingress
</pre>
Verificar los pods y servicios:

kubectl get all
Acceder a la aplicación en el navegador en http://php.local.

Despliegue Automatizado en WSL (Minikube o Docker Desktop)
1. Instalar y Configurar un Runner de GitHub Actions en WSL
Sigue estos pasos para configurar un runner local en tu entorno WSL:

En GitHub, ve a Settings > Actions > Runners > New self-hosted runner.

Sigue las instrucciones para configurar el runner en WSL.

2. Crear el Archivo de Workflow para el Despliegue Local
Configura un archivo de flujo de trabajo para ejecutar acciones de despliegue en tu entorno local WSL.

3. Instalar y Configurar el Servidor SSH en WSL
Si aún no tienes SSH instalado en WSL, ejecuta:

sudo apt update && sudo apt install openssh-server -y
Configura el servidor SSH y reinícialo:

sudo service ssh restart
4. Acceso Remoto a WSL
Usa Serveo para exponer tu WSL y acceder remotamente desde cualquier lugar:

ssh -R 2222:localhost:22 serveo.net5. Crear el Dockerfile
En el archivo Dockerfile, agrega el siguiente contenido para crear la imagen de Docker:
<pre>
FROM php:8.2-apache
COPY public/ /var/www/html/
EXPOSE 80
</pre>
6. Construir y Probar la Imagen Localmente (Opcional)
Construir la imagen Docker:
<pre>
docker build -t tu-usuario/php-k8s-app:latest .
docker push tu-usuario/php-k8s-app:latest
</pre>
Probar la imagen localmente:

docker run -p 8080:80 -e DB_HOST=localhost -e DB_USER=root -e DB_PASS= -e DB_NAME=demo tu-usuario/php-k8s-app:latest
Visita http://localhost:8080 para verificar que la aplicación funcione correctamente.

7. Crear un Registro en Docker Hub
Regístrate en Docker Hub.

Crea un nuevo repositorio en Docker Hub para almacenar la imagen de Docker.

8. Configurar GitHub Actions para CI/CD
Crea el archivo de flujo de trabajo en .github/workflows/deploy.yml con el siguiente contenido:
<pre>
name: Build and Deploy to Docker Hub
on:
  push:
    branches: [main]
jobs:
  build-and-push:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout repository
      uses: actions/checkout@v3

    - name: Log in to Docker Hub
      uses: docker/login-action@v1
      with:
        username: ${{ secrets.DOCKERHUB_USERNAME }}
        password: ${{ secrets.DOCKERHUB_TOKEN }}

    - name: Build and push Docker image
      uses: docker/build-push-action@v2
      with:
        context: .
        push: true
        tags: tu-usuario/php-k8s-app:latest
</pre>
9. Crear el Deployment de Kubernetes
Crea los archivos de configuración de Kubernetes en la carpeta k8s/:

deployment.yaml: Define el despliegue de la aplicación PHP y MySQL.

service.yaml: Configura el servicio de la aplicación PHP.

mysql-deployment.yaml: Despliega el contenedor de MySQL.

mysql-service.yaml: Define el servicio para MySQL.

ingress.yaml: Configura el ingreso para la aplicación PHP.

Aplica los manifiestos de Kubernetes con:

kubectl apply -f k8s/deployment.yaml
10. Pasos Siguientes Sugeridos
Modificar tu archivo hosts local para acceder a la aplicación mediante http://php.local.

Levantar el Ingress en Minikube (si no lo tienes activado).
minikube addons enable ingress
Verificar los pods y servicios:
kubectl get all
Acceder a la aplicación en el navegador en http://php.local.

Despliegue Automatizado en WSL (Minikube o Docker Desktop)
1. Instalar y Configurar un Runner de GitHub Actions en WSL
Sigue estos pasos para configurar un runner local en tu entorno WSL:

En GitHub, ve a Settings > Actions > Runners > New self-hosted runner.

Sigue las instrucciones para configurar el runner en WSL.

2. Crear el Archivo de Workflow para el Despliegue Local
Configura un archivo de flujo de trabajo para ejecutar acciones de despliegue en tu entorno local WSL.

3. Instalar y Configurar el Servidor SSH en WSL
Si aún no tienes SSH instalado en WSL, ejecuta:
sudo apt update && sudo apt install openssh-server -y
Configura el servidor SSH y reinícialo:
sudo service ssh restart
4. Acceso Remoto a WSL
Usa Serveo para exponer tu WSL y acceder remotamente desde cualquier lugar:
ssh -R 2222:localhost:22 serveo.net
