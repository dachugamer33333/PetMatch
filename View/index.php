
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petmatch - Encuentra a tu compañero perfecto</title>
    <style>
    /* Variables para colores */
    :root {
        --primary-color: #333; /* Un gris oscuro para contrastes suaves */
        --secondary-color: #f9f9f9; /* Fondo claro */
        --highlight-color: #ff6f61; /* Naranja para resaltar */
        --text-color: #555; /* Gris para texto */
        --shadow-color: rgba(0, 0, 0, 0.1);
        --dark-bg: #1a1a1a; /* Fondo para modo oscuro */
        --dark-text: #f1f1f1; /* Texto claro en modo oscuro */
    }

    /* General */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: var(--secondary-color);
        color: var(--text-color);
        line-height: 1.6;
        transition: background-color 0.3s, color 0.3s;
    }

    h1, h2, h3 {
        color: var(--primary-color);
    }

    a {
        text-decoration: none;
        color: var(--highlight-color);
        transition: color 0.3s;
    }

    a:hover {
        color: var(--primary-color);
    }

    /* Encabezado */
    header {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        box-shadow: 0 4px 6px var(--shadow-color);
    }

    header h1 {
        font-size: 24px;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    nav a {
        margin-left: 20px;
        color: var(--secondary-color);
        font-weight: bold;
    }

    /* Hero */
    .hero {
        text-align: center;
        background: linear-gradient(to right, var(--highlight-color), #ff9478);
        color: var(--secondary-color);
        padding: 100px 20px;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }

    .hero h2 {
        font-size: 48px;
        margin: 0 0 20px;
    }

    .hero p {
        font-size: 18px;
        margin-bottom: 30px;
    }

    .cta-button {
        background-color: var(--secondary-color);
        color: var(--highlight-color);
        padding: 10px 25px;
        border-radius: 25px;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        box-shadow: 0 3px 6px var(--shadow-color);
        transition: all 0.3s;
    }

    .cta-button:hover {
        background-color: var(--highlight-color);
        color: var(--secondary-color);
    }

    /* Secciones */
    .sections {
        max-width: 1100px;
        margin: auto;
        padding: 50px 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .section {
        padding: 20px;
        background-color: var(--secondary-color);
        border-radius: 10px;
        box-shadow: 0 4px 8px var(--shadow-color);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .section:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px var(--shadow-color);
    }

    .section h3 {
        font-size: 24px;
        margin-bottom: 15px;
        border-bottom: 2px solid var(--highlight-color);
        padding-bottom: 10px;
    }

    .section p {
        font-size: 16px;
    }

    /* Características */
    .features {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        padding: 50px 20px;
        text-align: center;
    }

    .features h3 {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .features ul {
        list-style: none;
        padding: 0;
        font-size: 18px;
    }

    .features li {
        margin-bottom: 10px;
    }

    /* Testimonios */
    .testimonials {
        max-width: 1100px;
        margin: 50px auto;
        padding: 20px;
        text-align: center;
    }

    .testimonial {
        margin-bottom: 30px;
        font-style: italic;
    }

    .testimonial blockquote {
        margin: 0;
        font-size: 18px;
    }

    .testimonial p {
        margin-top: 10px;
        font-weight: bold;
    }

    /* Formulario */
    .contact-us form {
        max-width: 600px;
        margin: auto;
        background: var(--secondary-color);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px var(--shadow-color);
    }

    .contact-us form label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .contact-us form input,
    .contact-us form textarea {
        width: 100%;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid var(--shadow-color);
        border-radius: 5px;
        font-size: 16px;
    }

    .contact-us form button {
        display: block;
        width: 100%;
        background-color: var(--highlight-color);
        color: var(--secondary-color);
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .contact-us form button:hover {
        background-color: var(--primary-color);
    }

    /* Footer */
    footer {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        text-align: center;
        padding: 20px;
        margin-top: 50px;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* Responsividad */
    @media (max-width: 768px) {
        .hero h2 {
            font-size: 36px;
        }

        .sections {
            grid-template-columns: 1fr;
        }
    }
</style>

</head>
<body>
<header>
    <h1>Petmatch</h1>
    <nav>
        <a href="register.php">Registrarse</a>
        <a href="login.php">Iniciar Sesión</a>
       
    </nav>
</header>

<section class="hero">
    <h2>Bienvenido a Petmatch</h2>
    <p>Encuentra a tu nuevo compañero de vida y cambia una vida hoy.</p>
    <a href="dashboard.php" class="cta-button">¡Comienza a buscar!</a>
</section>

<div class="sections">
    <div class="section">
        <h3>¿Quiénes Somos?</h3>
        <p>
            Somos Petmatch, una plataforma creada por estudiantes del CECYTEM. Nuestro propósito es conectar a las personas con mascotas que necesitan un hogar. Creemos que todos los animales merecen una vida llena de amor y cuidado, y trabajamos para facilitar la adopción de manera segura y responsable.
        </p>
    </div>
    <div class="section">
        <h3>¿Qué Buscamos?</h3>
        <p>
            Queremos crear una comunidad donde las mascotas puedan ser adoptadas fácilmente. Buscamos simplificar los procesos de adopción, brindando herramientas para publicar información detallada sobre cada mascota, como su edad, especie, fotos y características especiales.
        </p>
    </div>
    <div class="section">
        <h3>CECYTEM</h3>
        <p>
            Petmatch es un proyecto nacido en el Colegio de Estudios Científicos y Tecnológicos del Estado de México (CECYTEM). Este centro educativo fomenta la creatividad y la innovación en los jóvenes, permitiéndonos desarrollar herramientas que impacten positivamente a la sociedad.
        </p>
    </div>
    <div class="section">
        <h3>Beneficios de Adoptar</h3>
        <p>
            Adoptar una mascota no solo mejora su vida, sino también la tuya. Las mascotas brindan amor incondicional, reducen el estrés y contribuyen a mejorar nuestra salud emocional. ¡Haz la diferencia adoptando, no comprando!
        </p>
    </div>
</div>

<section class="features">
    <h3>Características de Petmatch</h3>
    <ul>
        <li>Sistema de chat en tiempo real para conectar adoptantes con asociaciones.</li>
        <li>Opciones de búsqueda avanzada para encontrar mascotas según tus preferencias.</li>
        <li>Reportes para asociaciones sobre el estado de las adopciones.</li>
        <li>Interfaz amigable y fácil de usar.</li>
    </ul>
</section>

<section class="testimonials">
    <h3>Testimonios</h3>
    <div class="testimonial">
        <blockquote>
            "Gracias a Petmatch encontré al mejor amigo que jamás pensé tener. ¡Recomiendo esta plataforma a todos!"
        </blockquote>
        <p>- Ana G.</p>
    </div>
    <div class="testimonial">
        <blockquote>
            "Adoptar nunca fue tan fácil. Petmatch me ayudó a conocer a Max, mi perro adoptado. Estoy muy agradecido."
        </blockquote>
        <p>- Luis M.</p>
    </div>
</section>



<footer>
    <p>&copy; 2024 Petmatch. Todos los derechos reservados. <a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
    <p>Síguenos en: 
        <a href="https://facebook.com/petmatch" target="_blank">Facebook</a> | 
        <a href="https://twitter.com/petmatch" target="_blank">Twitter</a> | 
        <a href="https://instagram.com/petmatch" target="_blank">Instagram</a>
    </p>
</
