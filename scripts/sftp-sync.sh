#!/usr/bin/env bash
# WP Engine SFTP helper for Marietta Spring.
# Requires: sshpass + OpenSSH sftp.
# Secrets load from .env.sftp — never echo or print the password.

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_FILE="${SFTP_ENV_FILE:-$ROOT/.env.sftp}"

usage() {
  cat <<'EOF'
Usage: scripts/sftp-sync.sh <command> [args]

Commands:
  test              Test SFTP login (pwd + short listing)
  list [remote]     List a remote path (default: SFTP_REMOTE_PATH or /)
  pull [theme]      Download remote theme → themes/<theme>/
  push [theme]      Upload themes/<theme>/ → remote theme (asks confirm)

Environment:
  Loads .env.sftp from the repo root (or SFTP_ENV_FILE).
  Required: SFTP_HOST, SFTP_PORT (2222), SFTP_USER, SFTP_PASS
  Optional: SFTP_REMOTE_PATH (default /wp-content/themes), SFTP_THEME

Examples:
  cp .env.sftp.example .env.sftp   # then edit credentials
  ./scripts/sftp-sync.sh test
  ./scripts/sftp-sync.sh list
  ./scripts/sftp-sync.sh list /wp-content/themes
  ./scripts/sftp-sync.sh pull amoja-child
  ./scripts/sftp-sync.sh push amoja-child
EOF
}

die() { echo "error: $*" >&2; exit 1; }

need_cmd() {
  command -v "$1" >/dev/null 2>&1 || die "missing dependency: $1"
}

load_env() {
  [[ -f "$ENV_FILE" ]] || die "missing $ENV_FILE — copy .env.sftp.example and fill credentials"
  set -a
  # shellcheck disable=SC1090
  source "$ENV_FILE"
  set +a
  : "${SFTP_HOST:?SFTP_HOST required}"
  : "${SFTP_USER:?SFTP_USER required}"
  : "${SFTP_PASS:?SFTP_PASS required}"
  SFTP_PORT="${SFTP_PORT:-2222}"
  SFTP_REMOTE_PATH="${SFTP_REMOTE_PATH:-/wp-content/themes}"
  export SSHPASS="$SFTP_PASS"
}

sftp_batch() {
  # Password via SSHPASS + sshpass -e (not printed, not in argv as plaintext arg).
  sshpass -e sftp -o StrictHostKeyChecking=accept-new -P "$SFTP_PORT" \
    "${SFTP_USER}@${SFTP_HOST}"
}

cmd_test() {
  need_cmd sshpass
  need_cmd sftp
  load_env
  echo "Testing SFTP → ${SFTP_USER}@${SFTP_HOST}:${SFTP_PORT} ..."
  printf 'pwd\nls -la\nbye\n' | sftp_batch >/dev/null
  echo "OK — connected. Remote path for theme sync: ${SFTP_REMOTE_PATH}"
}

cmd_list() {
  need_cmd sshpass
  need_cmd sftp
  load_env
  local target="${1:-$SFTP_REMOTE_PATH}"
  [[ -n "$target" ]] || target=/
  echo "Listing remote: ${target}"
  {
    echo "cd ${target}"
    echo "ls -la"
    echo "bye"
  } | sftp_batch
}

resolve_theme() {
  local theme="${1:-${SFTP_THEME:-}}"
  [[ -n "$theme" ]] || die "theme name required (arg or SFTP_THEME)"
  [[ "$theme" != *"/"* && "$theme" != "." && "$theme" != ".." ]] \
    || die "invalid theme name: $theme"
  echo "$theme"
}

remote_theme_path() {
  local theme="$1"
  local base="${SFTP_REMOTE_PATH%/}"
  echo "${base}/${theme}"
}

cmd_pull() {
  need_cmd sshpass
  need_cmd sftp
  load_env
  local theme
  theme="$(resolve_theme "${1:-}")"
  local remote
  remote="$(remote_theme_path "$theme")"
  local local_dir="$ROOT/themes/${theme}"
  mkdir -p "$ROOT/themes"
  # Fresh pull into a clean directory to avoid stale files
  rm -rf "$local_dir"
  mkdir -p "$local_dir"
  echo "Pulling ${remote}/ → themes/${theme}/"
  {
    echo "lcd ${local_dir}"
    echo "cd ${remote}"
    echo "get -r *"
    echo "bye"
  } | sftp_batch
  echo "Done → ${local_dir}"
}

cmd_push() {
  need_cmd sshpass
  need_cmd sftp
  load_env
  local theme
  theme="$(resolve_theme "${1:-}")"
  local remote
  remote="$(remote_theme_path "$theme")"
  local local_dir="$ROOT/themes/${theme}"
  [[ -d "$local_dir" ]] || die "local theme missing: themes/${theme} (pull first or create it)"
  echo "WARNING: This will upload local files to the live WP Engine theme:"
  echo "  local:  themes/${theme}/"
  echo "  remote: ${remote}/"
  if [[ "${SFTP_PUSH_YES:-}" != "1" ]]; then
    read -r -p "Type YES to continue: " confirm
    [[ "$confirm" == "YES" ]] || die "aborted"
  fi
  echo "Pushing themes/${theme}/ → ${remote}/"
  {
    echo "mkdir ${remote}"
    echo "cd ${remote}"
    echo "lcd ${local_dir}"
    echo "put -r *"
    echo "bye"
  } | sftp_batch
  echo "Done → ${remote}/"
}

main() {
  local cmd="${1:-}"
  shift || true
  case "$cmd" in
    test) cmd_test "$@" ;;
    list) cmd_list "$@" ;;
    pull) cmd_pull "$@" ;;
    push) cmd_push "$@" ;;
    -h|--help|help|"") usage ;;
    *) die "unknown command: $cmd (try --help)" ;;
  esac
}

main "$@"
