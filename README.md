# Curso de PHP — Ejercicios por Unidades

![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-777BB4)
![License](https://img.shields.io/badge/License-MIT-informational)
![Status](https://img.shields.io/badge/Status-Activo-brightgreen)

Repositorio de ejercicios del **Curso de PHP** orientado a backend. Verás desde sintaxis básica y arrays hasta **POO**, **formularios**, **sesiones/cookies**, **PDO/MySQL**, y un **mini MVC**. El enfoque es práctico y progresivo, con énfasis en **seguridad y buenas prácticas**.

---

## 📌 Objetivos del repositorio
- Entender la sintaxis y estructuras de control en PHP.
- Trabajar con arrays, strings y funciones de forma segura.
- Construir formularios con validación del lado servidor.
- Gestionar **sesiones/cookies** (autenticación básica).
- Conectar a **MySQL** con **PDO** (consultas preparadas).
- Montar un **mini MVC** y exponer endpoints simples.

---

## 🧭 Contenidos principales (temario)
- Sintaxis, tipos y operadores  
- Control de flujo (if/else, switch, loops)  
- Funciones y alcance  
- Arrays y Strings (manipulación segura)  
- **POO** (clases, herencia, interfaces, autoload PSR-4)  
- Formularios y **validación** (sanitización y filtrado)  
- **Sesiones y Cookies** (login básico)  
- **PDO + MySQL** (CRUD con consultas preparadas)  
- **MVC básico** (router simple, controladores, vistas)  
- **Composer** y dependencias  
- Seguridad (XSS, CSRF, SQLi)  
- Despliegue básico (estructura, `.env`, recomendaciones)

---

## 📂 Estructura
/unidad-01/ # Sintaxis y tipos
/unidad-02/ # Control de flujo
/unidad-03/ # Funciones, arrays, strings
/unidad-04/ # POO básica
/unidad-05/ # Formularios y validación
/unidad-06/ # Sesiones y cookies
/unidad-07/ # PDO + MySQL (CRUD)
/unidad-08/ # Mini MVC
/unidad-09/ # Seguridad básica
/unidad-10/ # Proyecto integrador


---

## 📚 Ejercicios por unidad

> Ajusta los enlaces a tu estructura real. Ejemplo: `./unidad-07/ejercicio-02/README.md`

### Unidad 1 — Sintaxis y tipos
- [U1E1: Hola PHP y phpinfo](./unidad-01/ejercicio-01/)
- [U1E2: Tipos, casting y operaciones](./unidad-01/ejercicio-02/)

### Unidad 2 — Control de flujo
- [U2E1: Condicionales y operadores](./unidad-02/ejercicio-01/)
- [U2E2: Bucles y patrones](./unidad-02/ejercicio-02/)

### Unidad 3 — Funciones, Arrays y Strings
- [U3E1: Funciones (params/retorno)](./unidad-03/ejercicio-01/)
- [U3E2: Arrays (asociativos, multidim.)](./unidad-03/ejercicio-02/)
- [U3E3: Strings (seguridad y filtros)](./unidad-03/ejercicio-03/)

### Unidad 4 — POO
- [U4E1: Clases y objetos](./unidad-04/ejercicio-01/)
- [U4E2: Herencia e interfaces](./unidad-04/ejercicio-02/)
- [U4E3: Autoload con Composer (PSR-4)](./unidad-04/ejercicio-03/)

### Unidad 5 — Formularios y Validación
- [U5E1: GET/POST y sanitización](./unidad-05/ejercicio-01/)
- [U5E2: Validación server-side](./unidad-05/ejercicio-02/)
- [U5E3: Subida de archivos](./unidad-05/ejercicio-03/)

### Unidad 6 — Sesiones y Cookies
- [U6E1: Login básico con sesiones](./unidad-06/ejercicio-01/)
- [U6E2: Recordar usuario con cookies](./unidad-06/ejercicio-02/)

### Unidad 7 — PDO + MySQL (CRUD)
- [U7E1: Conexión PDO y queries](./unidad-07/ejercicio-01/)
- [U7E2: CRUD seguro (prepared)](./unidad-07/ejercicio-02/)
- [U7E3: Paginación y búsqueda](./unidad-07/ejercicio-03/)

### Unidad 8 — Mini MVC
- [U8E1: Router simple](./unidad-08/ejercicio-01/)
- [U8E2: Controladores y Vistas](./unidad-08/ejercicio-02/)
- [U8E3: Modelo y capa DAO](./unidad-08/ejercicio-03/)

### Unidad 9 — Seguridad
- [U9E1: XSS y CSRF (protecciones)](./unidad-09/ejercicio-01/)
- [U9E2: SQLi y consultas preparadas](./unidad-09/ejercicio-02/)

### Unidad 10 — Proyecto Integrador
- [U10: Mini app MVC (auth + CRUD)](./unidad-10/proyecto/)

---

## ▶️ Cómo ejecutar los ejercicios

### Opción A — PHP embebido
1. Instala PHP 8.x (`php -v`).
2. Entra a la carpeta del ejercicio y ejecuta:  
   ```bash
   php -S localhost:8000
