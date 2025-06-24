
> ⚠️ Todos los archivos del proyecto deben estar dentro de la carpeta `htdocs` de XAMPP.  
> Por ejemplo: `C:\xampp\htdocs\miproyecto` en este caso lo llamamos restaurante.

## ⚙️ Configuración de XAMPP

1. **Instalá XAMPP** desde la página oficial si aún no lo tenés.
2. Abrí el **Panel de Control de XAMPP**.
3. Iniciá el módulo **Apache**.
   - Si Apache no inicia por un conflicto en el puerto 80, seguí estos pasos:
     - Hacé clic en `Config` al lado de Apache > `httpd.conf`
     - Cambiá la línea `Listen 80` por `Listen 8080`
     - Cambiá también `ServerName localhost:80` por `ServerName localhost:8080`
     - Guardá y reiniciá XAMPP.
4. Accedé al proyecto desde el navegador:
   - Si usás el puerto por defecto:
     ```
     http://localhost/miproyecto/index.php      http://localhost/restaurante/index.php
     ```
   - Si cambiaste a puerto 8080:
     ```
     http://localhost:8080/miproyecto/index.php    http://localhost:8080/restaurante/index.php
     ```

## 🧪 Cómo probar el proyecto

1. Colocá el proyecto en la carpeta `htdocs`:
2. Asegurate de que Apache esté corriendo en XAMPP.
3. Abrí tu navegador y entrá a: http://localhost:8080/restaurante
4. Deberías ver la salida generada por `index.php`.
5. Editar el archivo httpd-vhosts.conf, en la carpeta donde inslalo XAMPP, ejemplo: C:\xampp\apache\conf\extra
6. Agregar las siguientes lineas:
<VirtualHost *:8080>
    ServerName localhost
    DocumentRoot "Ubicacion de la carpeta del proyecto, D:/PHP/obligatorioPHP"
    <Directory "Ubicacion de la carpeta del proyecto, ejemplo: D:/PHP/obligatorioPHP">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
7. En el navegador ir a http://localhost:8080/phpmyadmin/index.php?route=/table/sql&db=restaurante&table=menu
8. En la Pestaña Base de datos:
- colocar el nombre de la base de datos
- en el comboBox siguiente seleccionar: utf8mb4_general_ci
- luego hacer clic en Crear
9. Ir a la pestaña Importar, luego Seleccionar archivo, aqui es donde va a buscar en el proyecto el archivo.sql 
10. Ahora si ya podemos ir a http://localhost:8080/restaurante/login.php