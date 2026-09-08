# Checklist de lanzamiento público

Documento operativo para abrir públicamente Primero el Voleibol cuando el proyecto esté listo.

> No ejecutar esta checklist mientras la web siga en revisión privada. La web debe permanecer protegida hasta completar las comprobaciones previas.

## Contexto y fuente de verdad

- Dominio público: `https://primeroelvoleibol.es`.
- Producción actual: OVHcloud, desplegada mediante GitHub Actions.
- `APP_URL=https://primeroelvoleibol.es` ya está correctamente configurado en producción.
- La protección actual del frontal se mantiene mediante HTTP Basic Auth en la configuración `.htaccess` de producción.
- Esta checklist no contiene pasos de Caddy ni de Synology/NAS: no corresponden al procedimiento de apertura de la producción actual.

## 1. Estado previo al lanzamiento

Mientras la web siga privada:

- [ ] Mantener HTTP Basic Auth en `.htaccess`.
- [ ] Mantener `robots.txt` con bloqueo total:

  ```text
  User-agent: *
  Disallow: /
  ```

- [ ] Mantener cualquier `noindex` existente.
- [ ] No enviar el sitemap a Google, Bing ni otros buscadores.
- [ ] No activar Analytics, GTM, píxeles ni tracking sin revisar antes las páginas legales y el consentimiento aplicable.
- [ ] Comprobar que los cambios siguen desplegándose correctamente mediante GitHub Actions.
- [ ] Comprobar que las páginas legales siguen reflejando las funcionalidades reales.
- [ ] Mantener sin cambios la configuración de producción, la indexación y los bloqueos de rastreo.

## 2. Preparación inmediatamente antes del lanzamiento

Ejecutar desde el entorno de desarrollo o CI, antes de retirar la protección:

```bash
php artisan test
vendor/bin/pint --test
npm run build
git diff --check
```

- [ ] Tests correctos.
- [ ] Pint limpio.
- [ ] Build correcto.
- [ ] `git diff --check` sin errores.
- [ ] GitHub Actions en verde.

Revisar manualmente en producción privada:

- [ ] Home.
- [ ] Proyecto.
- [ ] Programa.
- [ ] Blog y artículos publicados.
- [ ] Participa.
- [ ] Formularios de colaboración.
- [ ] Emails, adjuntos y uploads.
- [ ] Panel admin y login.
- [ ] Páginas legales.
- [ ] Navbar y footer.
- [ ] Responsive en móvil, tablet y escritorio.

Comprobar que no quedan placeholders, dominios `.test`, URLs HTTP internas, textos provisionales, enlaces rotos ni imágenes rotas.

## 3. Retirar Basic Auth

La protección actual del frontal está implementada mediante `.htaccess` en producción.

El día del lanzamiento:

- [ ] Eliminar únicamente las directivas de autenticación Basic Auth.
- [ ] Mantener el resto de reglas necesarias del `.htaccess`.
- [ ] No sustituir ni sobrescribir accidentalmente el archivo completo.
- [ ] Comprobar que la home responde sin usuario ni contraseña.
- [ ] Comprobar que `/admin` sigue funcionando correctamente.
- [ ] Comprobar que HTTPS continúa forzado.

No aplicar instrucciones relacionadas con Caddy para este procedimiento de producción.

## 4. Activar rastreo

Solo después de retirar Basic Auth y confirmar que la web está lista para ser pública, cambiar `robots.txt` a:

```text
User-agent: *
Disallow:

Sitemap: https://primeroelvoleibol.es/sitemap.xml
```

No aplicar este cambio antes del lanzamiento.

## 5. Revisar headers de indexación

El día del lanzamiento, comprobar los headers HTTP reales de producción:

- [ ] No existe `X-Robots-Tag: noindex`.
- [ ] No existe un bloqueo global `nofollow`, `noarchive`, `nosnippet` ni equivalente.
- [ ] Si aparece algún bloqueo, localizar primero su origen en `.htaccess`, Laravel o la configuración real de OVH.
- [ ] No asumir que el header procede de Caddy ni eliminar reglas sin identificar su origen.

## 6. Verificación SEO en producción

Después de abrir `https://primeroelvoleibol.es`, comprobar:

- [ ] Canonical.
- [ ] `title` específico.
- [ ] Meta description.
- [ ] Open Graph.
- [ ] Twitter/X Cards.
- [ ] `lang="es"`.
- [ ] `sitemap.xml`.
- [ ] `robots.txt`.
- [ ] Favicon.
- [ ] URLs HTTPS.
- [ ] Artículos con `og:type="article"`.
- [ ] Imágenes sociales.
- [ ] Enlaces internos.

Revisar especialmente:

- [ ] `/`
- [ ] `/proyecto`
- [ ] `/programa`
- [ ] `/blog`
- [ ] `/participa`
- [ ] Un artículo publicado.
- [ ] Páginas legales.

## 7. Sitemap

Comprobar `https://primeroelvoleibol.es/sitemap.xml`:

- [ ] Responde con HTTP 200.
- [ ] Contiene únicamente URLs públicas.
- [ ] Contiene los artículos publicados.
- [ ] No contiene admin, login, endpoints internos, URLs de test ni contenido privado.

## 8. Search Console

Solo después de confirmar que la web es pública e indexable:

- [ ] Añadir y verificar el dominio en Google Search Console.
- [ ] Enviar `https://primeroelvoleibol.es/sitemap.xml`.
- [ ] Comprobar cobertura e indexación.
- [ ] Revisar posibles errores de rastreo.

No configurar Search Console mientras la web siga privada.

## 9. Bing Webmaster Tools

Paso opcional posterior:

- [ ] Verificar el dominio.
- [ ] Enviar el mismo sitemap.

## 10. Privacidad y cookies antes del lanzamiento

Revisar que siguen siendo correctas la Política de Privacidad, el Aviso Legal, la Política de Cookies, los consentimientos de formularios y la información básica de privacidad.

Comprobar que desde la última revisión no se ha incorporado ninguno de estos elementos sin su revisión correspondiente:

- Analytics, Google Tag Manager, Meta Pixel o Hotjar.
- Vídeos embebidos o mapas.
- reCAPTCHA.
- Nuevos proveedores.
- Cookies no necesarias.
- Tracking.
- Newsletter comercial.

Si se ha añadido alguno, no lanzar sin revisar antes privacidad, cookies y consentimiento.

## 11. Pruebas funcionales posteriores a la apertura

Después de quitar Basic Auth probar:

- [ ] Envío identificado y anónimo de `/participa`.
- [ ] Solicitudes de colaboración de club, árbitro, entrenador y jugador.
- [ ] Adjuntos.
- [ ] Recepción de emails y enlaces Reply-To.
- [ ] Panel Filament y login admin.
- [ ] Imágenes públicas y privadas.
- [ ] Livewire y CSRF.
- [ ] Navbar, menú móvil y modales.
- [ ] Navegación por teclado y accesibilidad básica.

## 12. Seguridad

- [ ] `APP_ENV=production`.
- [ ] `APP_DEBUG=false`.
- [ ] HTTPS activo.
- [ ] Permisos de archivos revisados.
- [ ] `.env` no es público.
- [ ] Storage configurado correctamente.
- [ ] Basic Auth se ha retirado únicamente del frontal.
- [ ] El panel admin continúa protegido por autenticación.
- [ ] `FILAMENT_ADMIN_EMAIL` mantiene la restricción actual.
- [ ] No hay credenciales en logs ni vistas.

No incluir secretos reales en este documento.

## 13. Despliegue

La producción se despliega mediante GitHub Actions hacia OVHcloud.

No ejecutar ni documentar como procedimiento de producción:

- `npm install` en OVH.
- `npm run build` en OVH.
- `php artisan migrate:fresh`.
- `php artisan migrate:refresh`.
- `db:wipe`.
- `php artisan storage:link`.

El flujo de producción usa migraciones no destructivas mediante:

```bash
php artisan migrate --force
```

El storage público en OVH utiliza el symlink relativo:

```text
public/storage -> ../storage/app/public
```

No sustituirlo por `php artisan storage:link`.

## 14. Comprobación final

- [ ] Tests verdes.
- [ ] Pint limpio.
- [ ] Build correcto.
- [ ] GitHub Actions verde.
- [ ] Producción revisada.
- [ ] Basic Auth retirada.
- [ ] `robots.txt` abierto.
- [ ] Sitemap declarado.
- [ ] `noindex` eliminado.
- [ ] Canonicals correctos.
- [ ] Legales revisadas.
- [ ] Formularios probados.
- [ ] Emails probados.
- [ ] Admin probado.
- [ ] Search Console configurado.
- [ ] Sitemap enviado.
- [ ] Responsive revisado.
- [ ] HTTPS correcto.

## Notas de mantenimiento

- No modificar esta checklist para reflejar una infraestructura distinta sin confirmar primero el entorno real de producción.
- El `README.md` contiene una sección antigua de despliegue en Synology/NAS que no coincide con el despliegue actual en OVHcloud mediante GitHub Actions. Esta checklist no la toma como fuente de verdad.
- El `Caddyfile` pertenece al empaquetado de la aplicación, pero no debe usarse como procedimiento operativo para abrir la producción actual en OVHcloud.
- Las acciones potencialmente destructivas quedan expresamente excluidas. En particular, no usar comandos que borren la base de datos, regeneren migraciones, eliminen storage o sobrescriban `.htaccess` durante el lanzamiento.
