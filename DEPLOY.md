# Deploying to Coolify

The production image is the `Dockerfile` at the repository root. It builds the
front-end assets, installs PHP dependencies without dev packages, and serves the
app with FrankenPHP on port **80**.

There is **no database**. Content lives in `config/portfolio.php`, and sessions
are cookie-based, so the container is stateless: no volume is required and a
redeploy loses nothing.

---

## 1. Create the application in Coolify

- **+ New** → **Application** → **Public Repository** (or Private, via your
  GitHub app) and point it at this repository.
- **Build Pack:** `Dockerfile`
- **Dockerfile location:** `/Dockerfile`
- **Port:** `80`
- **Branch:** `main`

## 2. Environment variables

Set these under the application's **Environment Variables** tab. Everything
except `APP_KEY` can be copied as-is.

| Variable | Value |
| --- | --- |
| `APP_NAME` | `Luka Tsurtsumia` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | generate one - see below |
| `APP_URL` | `https://your-domain` |
| `APP_LOCALE` | `en` |
| `APP_FALLBACK_LOCALE` | `en` |
| `SESSION_DRIVER` | `cookie` |
| `SESSION_SECURE_COOKIE` | `true` |
| `CACHE_STORE` | `file` |
| `LOG_CHANNEL` | `stderr` |
| `LOG_LEVEL` | `warning` |

`APP_KEY` is the one value that must be generated, and it must stay the same
across deploys or existing session cookies stop decrypting:

```bash
php artisan key:generate --show
```

Copy the whole `base64:...` string. **Do not reuse the key from the local
`.env`** - that one has been on a development machine.

The container refuses to start without `APP_KEY`, with an explicit message in
the logs, rather than booting into a broken state.

## 3. Domain and TLS

Set the domain under **Domains** (e.g. `https://luka.boxeros.app`). Coolify
requests the certificate and terminates TLS at its proxy, forwarding plain HTTP
to port 80 in the container - which is why FrankenPHP is configured with
`SERVER_NAME=:80` and does not try to manage certificates itself.

Point the DNS A record at the server before deploying, or the certificate
request will fail.

## 4. Deploy

Press **Deploy**. The first build takes a few minutes (it installs Composer and
npm dependencies); later builds reuse the layer cache and are much faster.

Coolify's health check uses the `HEALTHCHECK` baked into the image, which polls
`/` every 30 seconds.

---

## Verifying a deploy

```bash
curl -I https://your-domain/            # 200, Server: FrankenPHP Caddy
curl -s https://your-domain/ | head -5  # HTML, not an error page
```

Then in a browser: scroll to the 3D Boxer section (it should animate), click a
project filter (cards should appear), and check the contact button opens Gmail.

## Running the production image locally

```bash
docker build -t luka-portfolio .
docker run --rm -p 8011:80 \
  -e APP_KEY="base64:..." \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e SESSION_DRIVER=cookie \
  luka-portfolio
```

Then open <http://localhost:8011>.

## Notes

- **Assets are built inside the image.** `public/build` is gitignored, so the
  image must run `npm run build` - it is not committed and cannot be skipped.
- **Caches are built at container start**, not at image build time, because
  Coolify injects the environment at runtime. Baking `config:cache` into the
  image would freeze whatever values existed on the build machine.
- **`bootstrap/cache` is excluded from the build context.** Laravel's discovered
  package manifest is written on the development machine and lists dev-only
  providers (Pail, Sail); copying it into a `--no-dev` image makes the container
  fail at boot with "Class not found".
