# Marietta Spring — WP Engine theme sync

Run this **from your machine** to talk to the Marietta Spring WordPress install on WP Engine over **SFTP (port 2222)** and sync themes under `wp-content/themes`.

## On your machine (quick start)

1. Clone / open this repo and checkout the branch with the sync tooling.
2. Install dependencies (see below for macOS / Linux).
3. Create a local credentials file (never commit it):

   ```bash
   cp .env.sftp.example .env.sftp
   ```

4. Edit `.env.sftp` with the WP Engine SFTP host, user, and password  
   (WP Engine → Sites → *install* → SFTP/SSH). Quote the password if it has special characters:

   ```bash
   SFTP_PASS='your-password-here'
   ```

5. Test, then pull or push:

   ```bash
   chmod +x scripts/sftp-sync.sh
   ./scripts/sftp-sync.sh test
   ./scripts/sftp-sync.sh pull amoja
   ./scripts/sftp-sync.sh pull amoja-child
   # edit locally, then:
   ./scripts/sftp-sync.sh push amoja-child   # type YES to confirm
   ```

If `test` fails, check WP Engine **IP allowlist** — your home/office IP must be allowed for SFTP.

## Prerequisites

- `sshpass`
- OpenSSH `sftp`

**macOS (Homebrew):**

```bash
brew install hudochenkov/sshpass/sshpass
# sftp is already part of macOS
```

**Debian/Ubuntu:**

```bash
sudo apt-get update && sudo apt-get install -y sshpass openssh-client
```

**Windows:** use WSL2 (Ubuntu) and the Debian/Ubuntu steps above, or any SFTP GUI (FileZilla, Cyberduck) with host / port `2222` / user / password from `.env.sftp.example` fields.

## Credentials (never commit)

`.env.sftp` is gitignored. Only `.env.sftp.example` (placeholders) is in git.

| Variable | Typical value |
| --- | --- |
| `SFTP_HOST` | `*.sftp.wpengine.com` |
| `SFTP_PORT` | `2222` |
| `SFTP_REMOTE_PATH` | `/wp-content/themes` |

On this WP Engine install the SFTP home **is** the WordPress site root (`/`). Themes live at `/wp-content/themes` (custom: `amoja`, `amoja-child`).

## Commands

```bash
./scripts/sftp-sync.sh test
./scripts/sftp-sync.sh list
./scripts/sftp-sync.sh list /wp-content/themes
./scripts/sftp-sync.sh pull amoja
./scripts/sftp-sync.sh pull amoja-child
./scripts/sftp-sync.sh push amoja-child
```

Pulled themes land under `themes/`. **`amoja` and `amoja-child` are versioned in git**; default WordPress themes (`twentytwenty*`) and secrets stay ignored.

## Manual one-offs / GUI

Interactive OpenSSH session (password via `SSHPASS`, never `echo` it):

```bash
set -a && source .env.sftp && set +a
export SSHPASS="$SFTP_PASS"
sshpass -e sftp -P "$SFTP_PORT" "${SFTP_USER}@${SFTP_HOST}"
```

Or use FileZilla / Cyberduck:

- Protocol: SFTP  
- Port: **2222**  
- Host / user / password: same as `.env.sftp`  
- Remote path for themes: `/wp-content/themes`

## Security notes

- Do not put the real password in git, README, PRs, or `.env.sftp.example`.
- WP Engine may restrict SFTP by IP allowlist; connection failures from your laptop often mean your IP is not allowed.
- Prefer pulling before pushing, and review diffs locally.
