
# 📚 TFG - VitalMe: Plataforma de Salud Integral

¡Hola! 👋 Soy Pablo de la Sierra, y este es mi **Trabajo de Fin de Grado (TFG)**: **VitalMe**, una plataforma innovadora de salud integral desarrollada con las últimas tecnologías web. A continuación, te explico en detalle qué es VitalMe, cómo se desarrolló y cómo puedes explorarlo.

---

## 🚀 **Idea del Proyecto**

VitalMe nace de la necesidad de ofrecer una **solución digital integral** para el cuidado de la salud, La plataforma está diseñada para hacer:

- 📊 Seguimiento preciso de macros y nutrientes
- 🏋️‍ Sistema de ejercicios personalizados
- 🎯 Gestión inteligente de objetivos
- 👥 Comunidad activa de usuarios

### 🔍 Problemas que Resuelve
| Problema Actual | Solución VitalFit |
|----------------|------------------|
| Apps genéricas sin personalización | Algoritmos adaptados a tu metabolismo |
| Dificultad para registrar comidas | Base de datos con +10,000 alimentos |
| Falta de motivación | Sistema de logros y comunidad |
---

## 🛠 **Tecnologías Utilizadas**

VitalMe está desarrollado con un **stack tecnológico moderno y robusto**:

### **Frontend** (Interactivo y dinámico)
- **Symfony** (Rendimiento optimizado)  
- **Bootstrap** (Diseño responsive y moderno)  
- **Chart.js** (Gráficos para métricas de salud)  
- **Formik & Yup** (Validación de formularios)  

### **Backend** (Escalable y seguro)
- **Node.js** + **Express** (API RESTful)  
- **MySQL** (Base de datos NoSQL flexible)    
- **JWT** (Autenticación segura)  

### **DevOps & Herramientas**
- **Git & GitHub** (Control de versiones)  
- **Postman** (Testing de APIs)  
- **ESLint & Prettier** (Calidad de código)  

---

## 📂 **Estructura del Proyecto**

El repositorio está organizado en:

```
📦 Proyecto-VitalMe
├── 📂 assets/            # Assets frontend
├── 📂 bin/               # Comandos Symfony
├── 📂 config/            # Configuración
├── 📂 migrations/        # Migraciones de BD
├── 📂 public/            # Punto de entrada
├── 📂 src/
│   ├── Controller/       # Controladores
│   ├── Entity/           # Entidades Doctrine
│   ├── Form/             # Formularios
│   ├── Repository/       # Repositorios
│   └── Service/          # Lógica de negocio
├── 📂 templates/         # Twig templates
├── 📂 tests/             # Pruebas
└── 📂 client/            # Frontend React/Vite
```

---

## 🔥 **Características Clave**

### **1. Autenticación Segura**  
- Registro y login con JWT (JSON Web Tokens).  
- Protección de rutas según rol (paciente, médico, admin).  

### **2. Dashboard de Salud Personalizado**  
- Visualización de métricas (peso, actividad física...).  
- Gráficos interactivos para seguimiento histórico.  

### **4. Recomendaciones Inteligentes**  
- Sugerencias de ejercicios, alimentación y descanso basadas en datos.  

### **5. Panel de Administración**  
- Gestión de usuarios (altas, bajas, permisos, usuarios).   

---

## 🎯 **Desarrollo y Desafíos**

### ✅ **Logros clave**  
- **Integración fluida** entre frontend y backend.  
- **Diseño responsive** que funciona en móvil y desktop.  
- **API RESTful bien estructurada** para futuras mejoras.  

## 📖 **Cómo Probarlo Localmente**

Si quieres ejecutar VitalMe en tu máquina:

### Requisitos previos
- PHP 8.2+
- Symfony CLI
- Composer
- MySQL 5.7+ o PostgreSQL
- Node.js 18+ (para el frontend)

### Pasos de instalación

1. **Clonar el repositorio**
``bash
git clone https://github.com/PaabloJ7/Proyecto-VitalMe.git
cd Proyecto-VitalMe
2. Instalar dependencias PHP

bash
composer install
Configurar entorno

bash
cp .env .env.local
# Editar .env.local con tus credenciales de BD
Crear base de datos

bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
Cargar datos iniciales (opcional)

bash
php bin/console doctrine:fixtures:load
Instalar assets frontend

bash
cd client
npm install
npm run build
Iniciar servidor Symfony

bash
symfony serve -d
Acceder a la aplicación

http://localhost:8000
---

## 📜 **Documentación Adicional**
- **Memoria del TFG**: Incluye justificación teórica, diagramas UML y análisis de requisitos.  
- **Presentación**: Resumen visual del proyecto (disponible en `/docs`).  

---

## 🌟 **Futuras Mejoras**
- [ ] **App móvil** (React Native).  
- [ ] **IA para diagnóstico predictivo** (ej: alertas tempranas).  
- [ ] **Integración con wearables** (Fitbit, Apple Health).  

---

## 🤝 **Contribuciones**
¡Agradezco feedback y sugerencias! Si encuentras un bug o tienes ideas, abre un **issue** o envía un **pull request**.

---

## 📧 **Contacto**
- **Autor**: Pablo de la Sierra 
- **GitHub**: [@PaabloJ7](https://github.com/PaabloJ7)  
- **LinkedIn**: [Pablo de la Sierra](https://www.linkedin.com/in/pablosierra-dev)  

---

**¡Gracias por tu interés en VitalMe!** ❤️  
