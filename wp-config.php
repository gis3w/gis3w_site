<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file definisce le seguenti configurazioni: impostazioni MySQL,
 * Prefisso Tabella, Chiavi Segrete, Lingua di WordPress e ABSPATH.
 * E' possibile trovare ultetriori informazioni visitando la pagina: del
 * Codex {@link http://codex.wordpress.org/Editing_wp-config.php
 * Editing wp-config.php}. E' possibile ottenere le impostazioni per
 * MySQL dal proprio fornitore di hosting.
 *
 * Questo file viene utilizzato, durante l'installazione, dallo script
 * rimepire i valori corretti.
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - E? possibile ottenere questoe informazioni
// ** dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define('DB_NAME', 'gis3w_site');

/** Nome utente del database MySQL */
define('DB_USER', 'root');

/** Password del database MySQL */
define('DB_PASSWORD', 'admin01');

/** Hostname MySQL  */
define('DB_HOST', 'localhost');

/** Charset del Database da utilizare nella creazione delle tabelle. */
define('DB_CHARSET', 'utf8');

/** Il tipo di Collazione del Database. Da non modificare se non si ha
idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * E' possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[ftM#Gu0@:mnR8P,D E^S=.Yq&-a}hJ5N;ySmRuxJ>)U.8^YG<^a>aGSgwzD!I4;');
define('SECURE_AUTH_KEY',  ')[IGH<m>/dk?6]@Si jnd^<rrtkSKpKEeXz7=M94;6X1a?JJ>8~mWFj_S3fRgQr1');
define('LOGGED_IN_KEY',    'Wk}RubiObZKcjR=&Bu-{_/<EYXC$^V7$IoV$NSBg/5? A4Q$67jiFYT+oIsJi-@<');
define('NONCE_KEY',        '%OZ*t[>~;i%)%!?&*iVBnXTLC7NJQ+F&Q)XO9{.|-/[q(M}_w4fj2_F;ld^e%|~%');
define('AUTH_SALT',        'ZWy8|{f@Fbt`&q]fhuLq6;?6+b^86>mrN]Er;_*vA$nvXk+fmHL!@tr.YWJVe-iJ');
define('SECURE_AUTH_SALT', 'X/UBZ$=W<9|2^_GW@ Q0-z)+z1-U.,~1n?WD6My6={ es}q[@OC197]+E<Q%bH|-');
define('LOGGED_IN_SALT',   'A7`Jmktu<$y)BHW>CS6V-?uRL+!k7:;}W8L*B9^{@W+I=+!SUMti|B@%f>$zD*Y4');
define('NONCE_SALT',       '5C%f5DcOY.5-e#*eX-->KpU]mDY]J7-#B9vqehR+J+G[Dd1@(E&@*nCEB7*C5.Hi');

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress .
 *
 * E' possibile avere installazioni multiple su di un unico database if you give each a unique
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix  = 'wp_';

/**
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * E' fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all'interno dei loro ambienti di sviluppo.
 */
define('WP_DEBUG', false);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta lle variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');

