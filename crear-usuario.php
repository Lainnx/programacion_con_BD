



<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once "modulos/meta.php"; ?>
    <title>Crear cuenta</title>
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
                    <div>
                        <label for="nombre">Nombre:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="text" name="nombre" id="nombre">
                        <p id="errorUsuario"></p>
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="password" name="password" id="password">
                    </div>
                    <div>
                        <label for="password2">Repite la contraseña:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="password2" name="password2" id="password2">
                        <p id="errorPassword"></p>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <!-- Acuerdate de poner el required -->
                        <input type="email" name="email" id="email">
                        <p id="errorEmail"></p>
                    </div>
                    <div>
                        <label for="password">Idioma</label>
                        <select name="idioma" id="idioma">
                            <option value="ESP" selected>ESP</option>
                            <option value="CAT">CAT</option>
                            <option value="ENG">ENG</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Crear cuenta</button>
                        <a href="acceso.php">Acceder</a>
                    </div>
                </fieldset>

            </form>
        </section>
    </main>
</body>
</html>