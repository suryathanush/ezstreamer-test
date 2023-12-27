#!/usr/bin/env bash
# HELP IS ON THE WAY
# Using this SSH reverse-tunnel
source /home/ezstreamer/ezstreamer/.env
trap 'pkill telnet;pkill ssh' EXIT


if [[ ! "$TERM" =~ screen ]] && [[ ! "$TERM" =~ tmux ]] && [ -z "$TMUX" ]; then
  tmux new-session \; \
  send-keys "clear;sleep 1;echo \"Help is on the way, please keep this window open\";ssh -NR 43022:localhost:22 ezstreamer_$UUID@$EZ_CLOUD_URL" C-m \; \
  split-window -v \; \
  send-keys "clear; sleep 1;telnet towel.blinkenlights.nl" Enter \; \
  select-layout main-horizontal \; \
  swap-pane -s2 -t1 \; \
  resize-pane -D 4
fi
