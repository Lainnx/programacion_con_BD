



<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once "modulos/meta.php"; ?>
    <title>Crear cuenta</title>
    <script src="js/crear-usuario.js" defer></script>
</head>
<body>
    <?php include_once "modulos/header.php" ?>

    <main class="main-crear-usuario">
        <section>
            <img src="img/colores.jpg" alt="espiral de colores">
        </section>
        <section>

            <form name="formNewUser">
                <fieldset>
                    <h2>Introduce tus datos</h2>
                    <div>
                        <label for="nombre">Nombre:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="text" name="nombre" id="nombre" >
                        <p id="errorUsuario"></p>
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="password" name="password" id="password" maxlength="12">
                    </div>
                    <div>
                        <label for="password2">Repite la contraseña:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="password" name="password2" id="password2" maxlength="12">
                        <p id="errorPassword"></p>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="email" name="email" id="email" maxlength="150">
                        <p id="errorEmail"></p>
                    </div>
                    <div>
                        <label for="idioma">Idioma</label>
                        <select name="idioma" id="idioma">
                            <option value="ESP" selected>ESP</option>
                            <option value="CAT">CAT</option>
                            <option value="ENG">ENG</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Crear cuenta</button>
                        <a href="iniciar-sesion.php">Ya tengo una cuenta</a>
                    </div>
                </fieldset>

            </form>
        </section>
    </main>


</body>
</html>