# justletmenow

Marketing website for **Just Let Me Now** — a family-run property renovation & rental company in South Wales. Live at <https://www.justletmenow.com>.

## What's here

| File | Purpose |
|------|---------|
| `index.html` | Home page — hero, what we do, before/after videos |
| `contact.html` | Contact page — form, phone, email |
| `contact.php` | Server-side handler that emails the form to `ashacks@gmail.com` |
| `styles.css` | Site styles (clean, modern, mobile-first) |
| `assets/` | Web-optimised videos, poster images, favicon |
| `.github/workflows/deploy.yml` | Auto-deploys to the FTP host on push to `main` |

## Deployment

Every push to `main` triggers the **Deploy to FTP** GitHub Action, which uploads the site to the web host over FTPS.

Credentials are **never** stored in the repo — they live in GitHub repository **Secrets**:

- `FTP_SERVER`
- `FTP_USERNAME`
- `FTP_PASSWORD`

To deploy manually, use the **Run workflow** button on the Actions tab (`workflow_dispatch`).

## Contact form

`contact.html` posts to `contact.php`, which sends the enquiry via PHP `mail()` and redirects back with a success/error banner. Requires PHP on the host. If email delivery proves unreliable, the form can be pointed at a service like Formspree with a one-line change to the form's `action`.

## Editing the videos

`assets/before.mp4` / `assets/after.mp4` are compressed copies. The original phone recordings are kept locally but git-ignored (not committed). To refresh them, re-encode with ffmpeg and replace the files in `assets/`.
