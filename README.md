
# 📚 TFG - VitalMe: Plataforma de Salud Integral

¡Hola! 👋 Soy Pablo Jiménez, y este es mi **Trabajo de Fin de Grado (TFG)**: **VitalMe**, una plataforma innovadora de salud integral desarrollada con las últimas tecnologías web. A continuación, te explico en detalle qué es VitalMe, cómo se desarrolló y cómo puedes explorarlo.

---

## 🚀 **Idea del Proyecto**

VitalMe nace de la necesidad de ofrecer una **solución digital integral** para el cuidado de la salud, combinando **seguimiento médico, bienestar físico y mental, y recomendaciones personalizadas**. La plataforma está diseñada para:

✔ **Pacientes**: Registran sus datos médicos, reciben recomendaciones y hacen un seguimiento de su salud.  
✔ **Médicos**: Acceden a historiales clínicos, analizan datos y brindan diagnósticos más precisos.  
✔ **Administradores**: Gestionan usuarios, permisos y contenido de la plataforma.

### 🔍 **Problema que resuelve**
- **Falta de integración** entre historial médico, actividad física y bienestar emocional.
- **Dificultad para acceder** a información médica centralizada.
- **Necesidad de personalización** en recomendaciones de salud.

---

## 🛠 **Tecnologías Utilizadas**

VitalMe está desarrollado con un **stack tecnológico moderno y robusto**:

### **Frontend** (Interactivo y dinámico)
- **React.js** + **Vite** (Rendimiento optimizado)  
- **Tailwind CSS** (Diseño responsive y moderno)  
- **React Router** (Navegación SPA)  
- **Chart.js** (Gráficos para métricas de salud)  
- **Formik & Yup** (Validación de formularios)  

### **Backend** (Escalable y seguro)
- **Node.js** + **Express** (API RESTful)  
- **MongoDB** (Base de datos NoSQL flexible)  
- **Mongoose** (Modelado de datos)  
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
├── 📂 client            # Frontend (React + Vite)
│   ├── src
│   │   ├── components   # Componentes reutilizables
│   │   ├── pages        # Vistas de la aplicación
│   │   ├── hooks        # Custom Hooks
│   │   ├── context      # Gestión de estado (Auth, etc.)
│   │   └── styles       # Estilos con Tailwind
├── 📂 server            # Backend (Node.js + Express)
│   ├── controllers      # Lógica de endpoints
│   ├── models           # Esquemas de MongoDB
│   ├── routes           # Rutas de la API
│   └── middleware       # Autenticación y validaciones
├── 📂 docs              # Documentación (memoria TFG, diagramas)
└── 📜 README.md         # Este archivo
```

---

## 🔥 **Características Clave**

### **1. Autenticación Segura**  
- Registro y login con JWT (JSON Web Tokens).  
- Protección de rutas según rol (paciente, médico, admin).  

### **2. Dashboard de Salud Personalizado**  
- Visualización de métricas (peso, presión arterial, actividad física).  
- Gráficos interactivos para seguimiento histórico.  

### **3. Historial Médico Digital**  
- Almacenamiento de consultas, diagnósticos y recetas.  
- Acceso rápido para médicos autorizados.  

### **4. Recomendaciones Inteligentes**  
- Sugerencias de ejercicios, alimentación y descanso basadas en datos.  

### **5. Panel de Administración**  
- Gestión de usuarios (altas, bajas, permisos).  
- Moderación de contenido médico.  

---

## 🎯 **Desarrollo y Desafíos**

### ✅ **Logros clave**  
- **Integración fluida** entre frontend y backend.  
- **Diseño responsive** que funciona en móvil y desktop.  
- **API RESTful bien estructurada** para futuras mejoras.  

### ⚠ **Desafíos superados**  
- **Gestión de estados complejos** (ej: datos médicos en tiempo real).  
- **Seguridad de datos sensibles** (encriptación, JWT).  
- **Optimización de consultas** a MongoDB para evitar lentitud.  

---

## 📖 **Cómo Probarlo Localmente**

Si quieres ejecutar VitalMe en tu máquina:

### **Requisitos previos**
- Node.js (v18+)  
- MongoDB (local o Atlas)  

### **Pasos**
1. Clona el repositorio:
   ```bash
   git clone https://github.com/PaabloJ7/Proyecto-VitalMe.git
   ```
2. Instala dependencias del **backend**:
   ```bash
   cd server
   npm install
   ```
3. Configura las variables de entorno (crea un `.env` basado en `.env.example`).  
4. Inicia el servidor:
   ```bash
   npm run dev
   ```
5. Instala dependencias del **frontend** (en otra terminal):
   ```bash
   cd ../client
   npm install
   ```
6. Ejecuta el frontend:
   ```bash
   npm run dev
   ```
7. Abre `http://localhost:5173` en tu navegador.  

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
- **Autor**: Pablo Jiménez  
- **GitHub**: [@PaabloJ7](https://github.com/PaabloJ7)  
- **LinkedIn**: [Pablo Jiménez](https://www.linkedin.com/in/tu-perfil)  

---

**¡Gracias por tu interés en VitalMe!** ❤️  
*"La salud es riqueza, y la tecnología puede ayudarnos a preservarla."*
