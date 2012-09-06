<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'masvalor');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '2)A3w#$[b~Uc2-A0j*;LSR}z_QPvR%UQ$>O6r@TXyR$,pa@$6>t6OzD%UxdQI_pZ'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'yiLD|&EmnHHUut!W:+v nn5%a1hnUI>.pYq:GtNbU3rSmoUk$Hwg$@L/G(qcN%Le'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'Ay0lyE-R]J@XdV;qg}t8R~Q*Z%.<z0O2RZ&7D3UmslZh(nAJ3j=!XrtU?%5@Fk^m'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', '3uB3y/~-Gn35$.8HdjW:pl]1o?iF77|f+5VriqsI!ch`h79;EZ#KpGoym}eLr:4D'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'TfXR3zh:Q8gk..iUiSdEVoKz*,#wOr/:)Yti+Yr]GDz5R&d4pRF7+T4`D8AM{#ZI'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', '{{H&4HE]}uo@tbkwp51n6d.|T2NAH5x7f_>uyjj0N[~8sF~2jp7E=A+2`= Zpz(4'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', ':%iLT+3c-Q1cV#?boAU1zF]vM8?%O)!8YzU- d]35f_/R]MZW45R@jCiy#Fqm{F}'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'b[cz-hJ&)^qtd%>~V{}LB?5OyIP0~i/d 1pWIiB*D|rh/A#)09v`Jc:j|zLWtUBv'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
